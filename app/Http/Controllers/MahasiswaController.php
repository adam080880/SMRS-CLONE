<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MahasiswaController extends Controller
{
    private function getMahasiswaAndUser()
    {
        $user = auth()->user();
        $mahasiswa = DB::table('mahasiswa')->where('email', $user->email)->first();

        if (!$mahasiswa) {
            throw Error('Mahasiswa\'s email not found');
        }

        return [
            'user' => $user,
            'mahasiswa' => $mahasiswa,
        ];
    }

    public function dashboard()
    {
        $authDetail = $this->getMahasiswaAndUser();

        $dosenPA = DB::table('dosen')->where('nip', $authDetail['mahasiswa']->pa_nip)->first();

        $total_sks_mahasiswa = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->sum('irs.sks');

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'dosenPA' => $dosenPA,
            'totalSKSMahasiswa' => $total_sks_mahasiswa
        ];

        return view('mhsDashboard', $data);
    }

    public function mahasiswaIrs()
    {
        $authDetail = $this->getMahasiswaAndUser();

        $mahasiswaSksBySemester = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->orderBy('mahasiswa_irs.semester', 'ASC')
            ->groupBy('mahasiswa_irs.semester')
            ->select('mahasiswa_irs.semester', DB::raw('SUM(irs.sks) as sum_sks'))
            ->get();

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'mahasiswaSksBySemester' => $mahasiswaSksBySemester
        ];

        return view('mhsDashboardIrs', $data);
    }

    public function mahasiswaIrsCreate()
    {
        $authDetail = $this->getMahasiswaAndUser();

        $total_sks_mahasiswa = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->sum('irs.sks');

        $irs_tersedia = DB::table('irs')
            ->join('mata_kuliah', 'mata_kuliah.kodemk', '=', 'irs.kode')
            ->where('mata_kuliah.plotsemester', '<=', $authDetail['mahasiswa']->semester_berjalan)
            ->orderBy(DB::raw("CASE WHEN mata_kuliah.plotsemester = {$authDetail['mahasiswa']->semester_berjalan} THEN 1 ELSE 0 END"), 'DESC')
            ->orderBy('mata_kuliah.plotsemester', 'ASC')
            ->get();
        $irs_terpilih = DB::table('irs')
            ->join('mata_kuliah', 'mata_kuliah.kodemk', '=', 'irs.kode')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.kode_irs', '=', 'irs.kode')
            ->join('mahasiswa_irs', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->where('mahasiswa_irs.semester', $authDetail['mahasiswa']->semester_berjalan)
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->orderBy(DB::raw("CASE WHEN mata_kuliah.plotsemester = {$authDetail['mahasiswa']->semester_berjalan} THEN 1 ELSE 0 END"), 'DESC')
            ->orderBy('mata_kuliah.plotsemester', 'ASC')
            ->get();

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'totalSKSMahasiswa' => $total_sks_mahasiswa,
            'irsTersedia' => $irs_tersedia,
            'irsTerpilih' => $irs_terpilih,
        ];

        return view('mhsDashboardCreateIrs', $data);
    }

    public function mahasiswaIrsDetail($semester)
    {
        $authDetail = $this->getMahasiswaAndUser();

        $mahasiswaIrsSemester = DB::table('mahasiswa_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->where('mahasiswa_irs.semester', $semester)
            ->first();
        $mahasiswaIrs = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.id', $mahasiswaIrsSemester->id)
            ->get();

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'mahasiswaIrsSemester' => $mahasiswaIrsSemester,
            'mahasiswaIrs' => $mahasiswaIrs
        ];

        return view('mhsDashboardIrsDetail', $data);
    }

    public function mahasiswaKhs()
    {
        $authDetail = $this->getMahasiswaAndUser();

        $mahasiswaSksBySemester = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->where('mahasiswa_irs.status', 'Approved')
            ->orderBy('mahasiswa_irs.semester', 'ASC')
            ->groupBy('mahasiswa_irs.semester')
            ->select('mahasiswa_irs.semester', DB::raw('SUM(irs.sks) as sum_sks'))
            ->get();

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'mahasiswaSksBySemester' => $mahasiswaSksBySemester
        ];

        return view('mhsDashboardKhs', $data);
    }

    public function mahasiswaKhsDetail($semester)
    {
        $authDetail = $this->getMahasiswaAndUser();

        $mahasiswaIrsSemester = DB::table('mahasiswa_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->where('mahasiswa_irs.semester', $semester)
            ->first();
        $mahasiswaIrs = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.id', $mahasiswaIrsSemester->id)
            ->get();
        
        $totalSksSemesterIni = 0;
        foreach ($mahasiswaIrs as $irs) {
            $totalSksSemesterIni += $irs->sks;
        }

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'mahasiswaIrsSemester' => $mahasiswaIrsSemester,
            'mahasiswaIrs' => $mahasiswaIrs,
            'totalSksSemesterIni' => $totalSksSemesterIni,
        ];

        return view('mhsDashboardKhsDetail', $data);
    }

    public function createMahasiswaIrs(Request $request)
    {
        try {
            $authDetail = $this->getMahasiswaAndUser();

            $mahasiswaIrs = DB::table('mahasiswa_irs')
                ->where('nim', $authDetail['mahasiswa']->nim)
                ->where('semester', $authDetail['mahasiswa']->semester_berjalan)
                ->first();

            if (!$mahasiswaIrs) {
                DB::table('mahasiswa_irs')
                    ->insert([
                        'nim' => $authDetail['mahasiswa']->nim,
                        'status' => 'Belum Diapprove',
                        'semester' => $authDetail['mahasiswa']->semester_berjalan,
                    ]);

                // refetch data terbaru
                $mahasiswaIrs = DB::table('mahasiswa_irs')
                    ->where('nim', $authDetail['mahasiswa']->nim)
                    ->where('semester', $authDetail['mahasiswa']->semester_berjalan)
                    ->first();
            } else {
                if ($mahasiswaIrs->status == 'Approved') {
                    throw new Exception('Irs sudah disetujui, sudah tidak boleh diganti');
                }
            }

            $allIrsKode = $request->post('irs');
            
            $newIrsMahasiswaDetail = [];

            foreach ($allIrsKode as $irsKode) {
                $newIrsMahasiswaDetail[] = [
                    'mahasiswa_irs_id' => $mahasiswaIrs->id,
                    'kode_irs' => $irsKode,
                ];
            }

            DB::table('mahasiswa_irs_detail')
                ->where('mahasiswa_irs_id', $mahasiswaIrs->id)
                ->delete();
            DB::table('mahasiswa_irs_detail')->insert($newIrsMahasiswaDetail);

            return response()->json([
                'data' => $mahasiswaIrs,
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'data' => null,
                'message' => $e->getMessage() ? $e->getMessage() : 'Error internal server error',
            ]);
        }
    }
}
