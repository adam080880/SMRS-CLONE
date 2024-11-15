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
                'nim' => '24060122140174',
                'nama' => 'Aryela Rachma Davina',
                'email' => 'yela@gmail.com',
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
            ],
            [
                'nim' => '24060122130070',
                'nama' => 'Indana Najwa Ramadhani',
                'email' => 'indananajwa@gmail.com',
                'no_telp' => '085001002003',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-04-04',
                'prodi' => 'Matematika',
                'jalur_masuk' => 'MANDIRI',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 5,
                'alamat' => 'Sigar Bencah',
                'status' => 'Aktif',
            ],
            [
                'nim' => '24060122140131',
                'nama' => 'Muhammad Raja Fadhil Habibi',
                'email' => 'rajafadhil@gmail.com',
                'no_telp' => '085338182967',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-01-05',
                'prodi' => 'Informatika',
                'jalur_masuk' => 'Mandiri',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 1,
                'alamat' => 'Alfamart Gondang',
                'status' => 'Aktif',
            ],
            [
                'nim' => '24060122140129',
                'nama' => 'Riski Akbar Firmansah',
                'email' => 'riskiakbar@gmail.com',
                'no_telp' => '085004005006',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2004-03-03',
                'prodi' => 'Fisika',
                'jalur_masuk' => 'MANDIRI',
                'angkatan' => 2022,
                'ipk' => 3.5,
                'semester_berjalan' => 5,
                'alamat' => 'Jl. Anggrek No. 3, Yogyakarta',
                'status' => 'Aktif',
            ],
        ]);
    }
}
