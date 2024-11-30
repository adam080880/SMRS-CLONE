<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * @dosen PA sample
         * ['nip' => '1234567801', 'nama' => 'Dr.Eng. Adi Wibowo, S.Si., M.Kom.', 'email' => 'adi.wibowo@gmail.com', 'no_telp' => '08123456001'],
         * ['nip' => '1234567802', 'nama' => 'Khadijah, S.Kom., M.Cs.', 'email' => 'khadijah@gmail.com', 'no_telp' => '08123456002'],
         * ['nip' => '1234567803', 'nama' => 'Prof. Dr. Dra. Sunarsih, M.Si.', 'email' => 'sunarsih@gmail.com', 'no_telp' => '08123456003'],
         */
        $user = [
            // Mahasiswa
            ['name' => 'Qaynan', 'email' => 'Qaynan@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'Thoriq', 'email' => 'Thoriq@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'Lucky', 'email' => 'Lucky@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Non Aktif'],
            ['name' => 'reva', 'email' => 'reva@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],

            ['name' => 'test5', 'email' => 'test5@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'test6', 'email' => 'test6@gmail.com', 'password' => '12345', 'role' => 'Pembimbing Akademik', 'prodi' => 'Informatika', 'pa'=>1, 'status' => 'Aktif'],
            ['name' => 'test7', 'email' => 'test7@gmail.com', 'password' => '12345', 'role' => 'Kaprodi', 'prodi' => 'Informatika', 'kp'=>1, 'dk'=>1, 'status' => 'Aktif'],
            ['name' => 'test8', 'email' => 'test8@gmail.com', 'password' => '12345', 'role' => 'Kaprodi', 'prodi' => 'Informatika', 'kp'=>1, 'status' => 'Aktif'],
            ['name' => 'test9', 'email' => 'test9@gmail.com', 'password' => '12345', 'role' => 'Kaprodi', 'prodi' => 'Fisika', 'kp'=>1, 'status' => 'Aktif'],
            ['name' => 'test10', 'email' => 'test10@gmail.com', 'password' => '12345', 'role' => 'Dekan', 'prodi' => 'Informatika', 'dk'=>1, 'status' => 'Aktif'],
            ['name' => 'test11', 'email' => 'test11@gmail.com', 'password' => '12345', 'role' => 'BA', 'prodi' => 'Informatika', 'ba'=>1, 'status' => 'Aktif'],

            // Pembimbing Akademik
            ['name' => 'Dr.Eng. Adi Wibowo, S.Si., M.Kom.', 'email' => 'adi.wibowo@gmail.com', 'password' => '12345', 'role' => 'Pembimbing Akademik', 'prodi' => 'Informatika', 'pa' => 1, 'status' => 'Aktif'],
            ['name' => 'Khadijah, S.Kom., M.Cs.', 'email' => 'khadijah@gmail.com', 'password' => '12345', 'role' => 'Pembimbing Akademik', 'prodi' => 'Informatika', 'pa' => 1, 'status' => 'Aktif'],
            ['name' => 'Prof. Dr. Dra. Sunarsih, M.Si.', 'email' => 'sunarsih@gmail.com', 'password' => '12345', 'role' => 'Pembimbing Akademik', 'prodi' => 'Informatika', 'pa' => 1, 'status' => 'Aktif'],
        ];

        foreach ($user as $p) {
            $p['password'] = Hash::make($p['password']); // Hash the password

            DB::table('users')->insert($p);
        }
    }
}
