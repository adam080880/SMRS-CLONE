<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $data = [
            'userName' => $authDetail['user']->name,
            'dosen' => $authDetail['mahasiswa']
        ];

        return view('mhsDashboard', $data);
    }
}
