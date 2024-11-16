<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            ['name' => 'test1', 'email' => 'test1@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Non Aktif'],
            ['name' => 'test2', 'email' => 'test2@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'test3', 'email' => 'test3@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'test4', 'email' => 'test4@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'test5', 'email' => 'test5@gmail.com', 'password' => '12345', 'role' => 'Mahasiswa', 'prodi'=> 'Informatika', 'mhs'=>1, 'status' => 'Aktif'],
            ['name' => 'test6', 'email' => 'test6@gmail.com', 'password' => '12345', 'role' => 'Pembimbing Akademik', 'prodi' => 'Informatika', 'pa'=>1],
            ['name' => 'test7', 'email' => 'test7@gmail.com', 'password' => '12345', 'role' => 'Kaprodi', 'prodi' => 'Informatika', 'kp'=>1, 'dk'=>1],
            ['name' => 'test8', 'email' => 'test8@gmail.com', 'password' => '12345', 'role' => 'Kaprodi', 'prodi' => 'Informatika', 'kp'=>1],
            ['name' => 'test9', 'email' => 'test9@gmail.com', 'password' => '12345', 'role' => 'Kaprodi', 'prodi' => 'Fisika', 'kp'=>1],
            ['name' => 'test10', 'email' => 'test10@gmail.com', 'password' => '12345', 'role' => 'Dekan', 'prodi' => 'Informatika', 'dk'=>1],
            ['name' => 'test11', 'email' => 'test11@gmail.com', 'password' => '12345', 'role' => 'BA', 'prodi' => 'Informatika', 'ba'=>1],
        ];

        foreach ($user as $p) {
            $p['password'] = Hash::make($p['password']); // Hash the password
            User::create($p);
        }
    }
}
