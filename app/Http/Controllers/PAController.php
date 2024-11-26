<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PAController extends Controller
{
    private function getDosenAndUser()
    {
        $user = auth()->user();
        $dosen = DB::table('dosen')->where('email', $user->email)->first();

        if (!$dosen) {
            throw Error('Dosen\'s email not found');
        }

        return [
            'user' => $user,
            'dosen' => $dosen,
        ];
    }

    public function dashboard()
    {
        $authDetail = $this->getDosenAndUser();

        $data = [
            'userName' => $authDetail['user']->name,
            'dosen' => $authDetail['dosen']
        ];

        return view('paDashboard', $data);
    }

    public function list()
    {
        $authDetail = $this->getDosenAndUser();
        $mahasiswaPerwalian = DB::table('mahasiswa')
            ->select('mahasiswa.*', 'mahasiswa_irs.semester as semester_saat_ini', 'mahasiswa_irs.status as status_pengajuan')
            ->leftJoin('mahasiswa_irs', function ($join) {
                $join->on('mahasiswa_irs.nim', '=', 'mahasiswa.nim');
                $join->on('mahasiswa_irs.semester', '=', 'mahasiswa.semester_berjalan');
            })
            ->where('mahasiswa.pa_nip', $authDetail['dosen']->nip)
            ->get();            

        $data = [
            'userName' => $authDetail['user']->name,
            'dosen' => $authDetail['dosen'],
            'mahasiswaPerwalian' => $mahasiswaPerwalian,
        ];

        return view('paIrsListDashboard', $data);
    }

    public function detail($nim)
    {
        $authDetail = $this->getDosenAndUser();

        $mahasiswa = DB::table('mahasiswa')
            ->select('mahasiswa.*', 'mahasiswa_irs.status as status_pengajuan')
            ->leftJoin('mahasiswa_irs', function($join) {
                $join->on('mahasiswa_irs.nim', '=', 'mahasiswa.nim');
                $join->on('mahasiswa_irs.semester', '=', 'mahasiswa.semester_berjalan');
            })
            ->where('mahasiswa.pa_nip', $authDetail['dosen']->nip)
            ->where('mahasiswa.nim', $nim)
            ->first();

        $mahasiswaIrsTerpilih = [];

        if ($mahasiswa) {
            $mahasiswaIrsTerpilih = DB::table('irs')
                ->join('mata_kuliah', 'mata_kuliah.kodemk', '=', 'irs.kode')
                ->join('mahasiswa_irs_detail', 'mahasiswa_irs_detail.kode_irs', '=', 'irs.kode')
                ->join('mahasiswa_irs', 'mahasiswa_irs_detail.mahasiswa_irs_id', '=', 'mahasiswa_irs.id')
                ->where('mahasiswa_irs.semester', $mahasiswa->semester_berjalan)
                ->where('mahasiswa_irs.nim', $nim)
                ->get();
        }

        $data = [
            'userName' => $authDetail['user']->name,
            'dosen' => $authDetail['dosen'],
            'mahasiswa' => $mahasiswa,
            'mahasiswaIrsTerpilih' => $mahasiswaIrsTerpilih,
        ];

        return view('paIrsDetailDashboard', $data);
    }

    public function approveIrs($nim)
    {
        $authDetail = $this->getDosenAndUser();

        $mahasiswa = DB::table('mahasiswa')
            ->select('mahasiswa.*', 'mahasiswa_irs.status as status_pengajuan')
            ->join('mahasiswa_irs', function($join) {
                $join->on('mahasiswa_irs.nim', '=', 'mahasiswa.nim');
                $join->on('mahasiswa_irs.semester', '=', 'mahasiswa.semester_berjalan');
            })
            ->where('mahasiswa.pa_nip', $authDetail['dosen']->nip)
            ->where('mahasiswa.nim', $nim)
            ->first();
        
        DB::table('mahasiswa_irs')
            ->where('semester', $mahasiswa->semester_berjalan)
            ->where('nim', $mahasiswa->nim)
            ->update([
                'status' => 'Approved',
            ]);
    }

    public function rejectIrs($nim)
    {
        $authDetail = $this->getDosenAndUser();

        $mahasiswa = DB::table('mahasiswa')
            ->select('mahasiswa.*', 'mahasiswa_irs.status as status_pengajuan')
            ->join('mahasiswa_irs', function($join) {
                $join->on('mahasiswa_irs.nim', '=', 'mahasiswa.nim');
                $join->on('mahasiswa_irs.semester', '=', 'mahasiswa.semester_berjalan');
            })
            ->where('mahasiswa.pa_nip', $authDetail['dosen']->nip)
            ->where('mahasiswa.nim', $nim)
            ->first();
        
        DB::table('mahasiswa_irs')
            ->where('semester', $mahasiswa->semester_berjalan)
            ->where('nim', $mahasiswa->nim)
            ->update([
                'status' => 'Ditolak',
            ]);
    }
}
