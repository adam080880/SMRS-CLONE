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
            ->select('mahasiswa.*')
            ->where('mahasiswa.pa_nip', $authDetail['dosen']->nip)
            ->get();

        $data = [
            'userName' => $authDetail['user']->name,
            'dosen' => $authDetail['dosen'],
            'mahasiswaPerwalian' => $mahasiswaPerwalian,
        ];

        return view('paIrsListDashboard', $data);
    }

    public function detail($irsId)
    {
        return view('paIrsDetailDashboard');
    }
}
