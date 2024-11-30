<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use StdClass;

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

    private function getMahasiswaIps($nim, $semester)
    {
        $getAllKhsSemesterBelow = DB::table('khs')
            ->select(DB::raw('MAX(bobot) as max_bobot'), 'khs.kode', 'irs.sks', 'khs.semester')
            ->where('khs.nim', $nim)
            ->where('khs.semester', '=', $semester)
            ->join('irs', 'khs.kode', '=', 'irs.kode')
            ->orderBy('khs.bobot', 'desc')
            ->groupBy('irs.kode')
            ->get();

        $totalSksTelahDiambil = 0;
        $totalSksBobotIps = 0;

        foreach ($getAllKhsSemesterBelow as $khsBefore) {
            $totalSksTelahDiambil += $khsBefore->sks;
            $totalSksBobotIps += ($khsBefore->sks * $khsBefore->max_bobot);
        }

        if (count($getAllKhsSemesterBelow) > 0) {
            $ips = round($totalSksBobotIps / $totalSksTelahDiambil, 2);
        } else {
            $ips = 0;
        }

        $returnFunction = new StdClass();
        $returnFunction->ips = $ips;
        $returnFunction->totalSksBobotIps = $totalSksBobotIps;
        $returnFunction->totalSksTelahDiambil = $totalSksTelahDiambil;

        $returnFunction->maxBebanSksYangDapatDiambil = 18;

        if ($ips >= 2 && $ips < 2.5) {
            $returnFunction->maxBebanSksYangDapatDiambil = 20;
        } else if ($ips >= 2.5 && $ips < 3) {
            $returnFunction->maxBebanSksYangDapatDiambil = 22;
        } else if ($ips >= 3) {
            $returnFunction->maxBebanSksYangDapatDiambil = 24;
        }

        return $returnFunction;
    }

    private function getMahasiswaIpkAndSksk($nim, $semester)
    {
        $getAllKhsSemesterBelow = DB::table('khs')
            ->select(DB::raw('MAX(bobot) as max_bobot'), 'khs.kode', 'irs.sks', 'khs.semester')
            ->where('khs.nim', $nim)
            ->where('khs.semester', '<=', $semester)
            ->join('irs', 'khs.kode', '=', 'irs.kode')
            ->orderBy('khs.bobot', 'desc')
            ->groupBy('irs.kode')
            ->get();

        $totalSksTelahDiambil = 0;
        $totalSksBobotIpk = 0;

        if (count($getAllKhsSemesterBelow) > 0) {
            foreach ($getAllKhsSemesterBelow as $khsBefore) {
                $totalSksTelahDiambil += $khsBefore->sks;
                $totalSksBobotIpk += ($khsBefore->sks * $khsBefore->max_bobot);
            }
    
            $ipk = round($totalSksBobotIpk / $totalSksTelahDiambil, 2);
        } else {
            $ipk = 0;
        }

        $returnFunction = new StdClass();
        $returnFunction->ipk = $ipk;
        $returnFunction->totalSksBobotIpk = $totalSksBobotIpk;
        $returnFunction->totalSksTelahDiambil = $totalSksTelahDiambil;

        return $returnFunction;
    }

    public function dashboard()
    {
        $authDetail = $this->getMahasiswaAndUser();
        $ipk = $this->getMahasiswaIpkAndSksk($authDetail['mahasiswa']->nim, $authDetail['mahasiswa']->semester_berjalan);

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
            'totalSKSMahasiswa' => $total_sks_mahasiswa,
            'ipk' => $ipk,
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
        $ipkAndSksk = $this->getMahasiswaIpkAndSksk($authDetail['mahasiswa']->nim, $authDetail['mahasiswa']->semester_berjalan);
        $ips = $this->getMahasiswaIps($authDetail['mahasiswa']->nim, $authDetail['mahasiswa']->semester_berjalan - 1);

        $total_sks_mahasiswa = DB::table('mahasiswa_irs')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->sum('irs.sks');

        $irs_tersedia = DB::table('irs')
            ->join('mata_kuliah', 'mata_kuliah.kodemk', '=', 'irs.kode')
            ->leftJoin('ruang', 'irs.ruang', '=', 'ruang.noruang')
            ->where('mata_kuliah.plotsemester', '<=', $authDetail['mahasiswa']->semester_berjalan)
            ->orderBy(DB::raw("CASE WHEN mata_kuliah.plotsemester = {$authDetail['mahasiswa']->semester_berjalan} THEN 1 ELSE 0 END"), 'DESC')
            ->orderBy('mata_kuliah.plotsemester', 'ASC')
            ->get();
        $irs_terpilih = DB::table('irs')
            ->join('mata_kuliah', 'mata_kuliah.kodemk', '=', 'irs.kode')
            ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.kode_irs', '=', 'irs.kode')
            ->join('mahasiswa_irs', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
            ->leftJoin('ruang', 'irs.ruang', '=', 'ruang.noruang')
            ->where('mahasiswa_irs.semester', $authDetail['mahasiswa']->semester_berjalan)
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->orderBy(DB::raw("CASE WHEN mata_kuliah.plotsemester = {$authDetail['mahasiswa']->semester_berjalan} THEN 1 ELSE 0 END"), 'DESC')
            ->orderBy('mata_kuliah.plotsemester', 'ASC')
            ->get();

        $all_count_irs_terpilih = DB::table('irs')
            ->select('irs.kode', DB::raw('COUNT(mahasiswa_irs_detail.id) as count_terisi'))
            ->leftJoin('mahasiswa_irs_detail', 'mahasiswa_irs_detail.kode_irs', '=', 'irs.kode')
            ->leftJoin('mahasiswa_irs', 'mahasiswa_irs.id', '=', 'mahasiswa_irs_detail.mahasiswa_irs_id')
            ->where(function($condition) use ($authDetail) {
                $condition->where('mahasiswa_irs.nim', '!=', $authDetail['mahasiswa']->nim)
                    ->orWhereNull('mahasiswa_irs.nim');
            })
            ->whereIn('irs.kode', array_column($irs_tersedia->toArray(), 'kode'))
            ->groupBy('irs.kode')
            ->get();

        $mapCountIrsTerpilihByKodeIrs = [];
        foreach ($all_count_irs_terpilih as $count_irs_terpilih) {
            $mapCountIrsTerpilihByKodeIrs[$count_irs_terpilih->kode] = $count_irs_terpilih;
        }

        foreach ($irs_tersedia as $irs) {
            $irs->terisi = 0;
            if (isset($mapCountIrsTerpilihByKodeIrs[$irs->kode])) {
                $irs->terisi = $mapCountIrsTerpilihByKodeIrs[$irs->kode]->count_terisi;
            }
        }
        foreach ($irs_terpilih as $irs) {
            $irs->terisi = 0;
            if (isset($mapCountIrsTerpilihByKodeIrs[$irs->kode])) {
                $irs->terisi = $mapCountIrsTerpilihByKodeIrs[$irs->kode]->count_terisi;
            }
        }

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'totalSKSMahasiswa' => $total_sks_mahasiswa,
            'irsTersedia' => $irs_tersedia,
            'irsTerpilih' => $irs_terpilih,
            'ipkAndSksk' => $ipkAndSksk,
            'ips' => $ips,
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

    public function mahasiswaKhsDetail(Request $request, $semester)
    {
        $uri = $request->path();
        $isPrint = false;

        if (str_contains($uri, "print")) {
            $isPrint = true;
        }

        $authDetail = $this->getMahasiswaAndUser();

        $mahasiswaIrsSemester = DB::table('mahasiswa_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->where('mahasiswa_irs.semester', $semester)
            ->first();

        $mahasiswaIrs = [];

        if ($mahasiswaIrsSemester) {
            $mahasiswaIrs = DB::table('mahasiswa_irs')
                ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
                ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
                ->join('khs', function($join) {
                    $join->on('khs.kode', '=', 'mahasiswa_irs_detail.kode_irs');
                    $join->on('khs.semester', '=', 'mahasiswa_irs.semester');
                    $join->on('khs.nim', '=', 'mahasiswa_irs.nim');
                })
                ->where('mahasiswa_irs.id', $mahasiswaIrsSemester->id)
                ->where('khs.semester', $semester)
                ->get();
        }

        $getAllKhsSemesterBelow = DB::table('khs')
            ->select(DB::raw('MAX(bobot) as max_bobot'), 'khs.kode', 'irs.sks', 'khs.semester')
            ->where('khs.nim', $authDetail['mahasiswa']->nim)
            ->where('khs.semester', '<=', $semester)
            ->join('irs', 'khs.kode', '=', 'irs.kode')
            ->orderBy('khs.bobot', 'desc')
            ->groupBy('irs.kode')
            ->get();
        
        $totalSksSemesterIni = 0;
        $totalBobot = 0;
        $totalSksBobot = 0;

        foreach ($mahasiswaIrs as $irs) {
            $totalSksSemesterIni += $irs->sks;
            $totalBobot += $irs->bobot;

            $totalSksBobot += ($irs->sks * $irs->bobot);
        }

        if ($mahasiswaIrsSemester && count($mahasiswaIrs) > 0) {
            $ips = $totalSksBobot / $totalSksSemesterIni;
        } else {
            $ips = 0;
        }

        $totalSksTelahDiambil = 0;
        $totalSksBobotIpk = 0;

        if (count($getAllKhsSemesterBelow) > 0) {
            foreach ($getAllKhsSemesterBelow as $khsBefore) {
                $totalSksTelahDiambil += $khsBefore->sks;
                $totalSksBobotIpk += ($khsBefore->sks * $khsBefore->max_bobot);
            }
    
            $ipk = round($totalSksBobotIpk / $totalSksTelahDiambil, 2);
        } else {
            $ipk = 0;
        }

        $data = [
            'isPrint' => $isPrint,
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'mahasiswaIrsSemester' => $mahasiswaIrsSemester,
            'mahasiswaIrs' => $mahasiswaIrs,
            'totalSksSemesterIni' => $totalSksSemesterIni,
            'totalSksBobot' => $totalSksBobot,
            'totalBobot' => $totalBobot,
            'ips' => round($ips, 2),

            'semester' => $semester,
            'totalSksBobotIpk' => $totalSksBobotIpk,
            'totalSksTelahDiambil' => $totalSksTelahDiambil,
            'ipk' => round($ipk, 2),
        ];

        return view('mhsDashboardKhsDetail', $data);
    }

    public function mahasiswaJadwal(Request $request)
    {
        $uri = $request->path();
        $isPrint = false;

        if (str_contains($uri, "print")) {
            $isPrint = true;
        }

        $authDetail = $this->getMahasiswaAndUser();
        $semester = $authDetail['mahasiswa']->semester_berjalan;

        $mahasiswaIrsSemester = DB::table('mahasiswa_irs')
            ->where('mahasiswa_irs.nim', $authDetail['mahasiswa']->nim)
            ->where('mahasiswa_irs.semester', $semester)
            ->first();

        $mahasiswaIrs = [];

        if ($mahasiswaIrsSemester) {
            $mahasiswaIrs = DB::table('mahasiswa_irs')
                ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
                ->join('irs', 'irs.kode', '=', 'mahasiswa_irs_detail.kode_irs')
                ->where('mahasiswa_irs.id', $mahasiswaIrsSemester->id)
                ->get();
        }

        $data = [
            'isPrint' => $isPrint,
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
            'mahasiswaIrsSemester' => $mahasiswaIrsSemester,
            'mahasiswaIrs' => $mahasiswaIrs,
            'semester' => $semester,
        ];

        return view('mhsDashboardJadwal', $data);
    }

    public function registrasi()
    {
        $authDetail = $this->getMahasiswaAndUser();

        $data = [
            'userName' => $authDetail['mahasiswa']->nama,
            'mahasiswa' => $authDetail['mahasiswa'],
        ];

        return view('mhsRegistrasi', $data);
    }

    public function createMahasiswaIrs(Request $request)
    {
        try {
            $authDetail = $this->getMahasiswaAndUser();

            if ($authDetail['mahasiswa']->status !== 'Aktif') {
                throw new Exception('Status Mahasiswa tidak aktif, mohon aktifkan terlebih dahulu di Menu Registrasi.');
            }

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

    public function aktivasi(Request $request)
    {
        try {
            $authDetail = $this->getMahasiswaAndUser();

            if ($authDetail['mahasiswa']->payment == false) {
                throw new Exception('Mahasiswa belum melakukan pembayaran, harap lakukan pembayaran terlebih dahulu');
            }

            DB::table('users')
                ->where('id', $authDetail['user']->id)
                ->update([
                    'status' => 'Aktif'
                ]);

            DB::table('mahasiswa')
                ->where('id', $authDetail['mahasiswa']->id)
                ->update([
                    'status' => 'Aktif'
                ]);

            return response()->json([
                'data' => null,
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

    public function payment(Request $request)
    {
        try {
            $authDetail = $this->getMahasiswaAndUser();

            DB::table('mahasiswa')
                ->where('id', $authDetail['mahasiswa']->id)
                ->update([
                    'payment' => true
                ]);

            return response()->json([
                'data' => null,
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
