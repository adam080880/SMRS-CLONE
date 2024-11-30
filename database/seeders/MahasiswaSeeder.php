<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'nim' => '24060122140123',
                'nama' => 'Qaynan',
                'email' => 'Qaynan@gmail.com',
                'no_telp' => '085000000000',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-02-02',
                'prodi' => 'Informatika',
                'jalur_masuk' => 'SNBP',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 5,
                'alamat' => 'Sigar Bencah',
                'status' => 'Aktif',
                'pa_nip' => '1234567801',
                'payment' => true,
            ],
            [
                'nim' => '24060122140124',
                'nama' => 'Thoriq',
                'email' => 'Thoriq@gmail.com',
                'no_telp' => '085001002003',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-04-04',
                'prodi' => 'Informatika',
                'jalur_masuk' => 'MANDIRI',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 5,
                'alamat' => 'Sigar Bencah',
                'status' => 'Aktif',
                'pa_nip' => '1234567801',
                'payment' => true,
            ],
            [
                'nim' => '240601221401235',
                'nama' => 'Lucky',
                'email' => 'Lucky@gmail.com',
                'no_telp' => '085338182967',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-01-05',
                'prodi' => 'Informatika',
                'jalur_masuk' => 'Mandiri',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 1,
                'alamat' => 'Alfamart Gondang',
                'status' => 'Non Aktif',
                'pa_nip' => '1234567801',
                'payment' => false,
            ],
            [
                'nim' => '24060122140126',
                'nama' => 'Reva',
                'email' => 'reva@gmail.com',
                'no_telp' => '085004005006',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-03-03',
                'prodi' => 'Informatika',
                'jalur_masuk' => 'MANDIRI',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 5,
                'alamat' => 'Jl. Anggrek No. 3, Yogyakarta',
                'status' => 'Aktif',
                'pa_nip' => '1234567802',
                'payment' => true,
            ],
        ]);
    }
}
