<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosen = [
            ['nip' => '1234567801', 'nama' => 'Dr.Eng. Adi Wibowo, S.Si., M.Kom.', 'email' => 'adi.wibowo@gmail.com', 'no_telp' => '08123456001'],
            ['nip' => '1234567802', 'nama' => 'Khadijah, S.Kom., M.Cs.', 'email' => 'khadijah@gmail.com', 'no_telp' => '08123456002'],
            ['nip' => '1234567803', 'nama' => 'Prof. Dr. Dra. Sunarsih, M.Si.', 'email' => 'sunarsih@gmail.com', 'no_telp' => '08123456003'],
            ['nip' => '1234567804', 'nama' => 'Solikhin, S.Si., M.Sc.', 'email' => 'solikhin@gmail.com', 'no_telp' => '08123456004'],
            ['nip' => '1234567805', 'nama' => 'Dra. Endang Kumaidah, M.Kes.', 'email' => 'endang.kumaidah@gmail.com', 'no_telp' => '08123456005'],
            ['nip' => '1234567806', 'nama' => 'Dra. R.A.J. Atrinawati, M.Hum.', 'email' => 'atrinawati@gmail.com', 'no_telp' => '08123456006'],
            ['nip' => '1234567807', 'nama' => 'Dr. Retno Kusumaningrum, S.Si., M.Kom.', 'email' => 'retno.kusumaningrum@gmail.com', 'no_telp' => '08123456007'],
            ['nip' => '1234567808', 'nama' => 'Priyo Sidik Sasongko, S.Si., M.Kom.', 'email' => 'priyo.sasongko@gmail.com', 'no_telp' => '08123456008'],
            ['nip' => '1234567809', 'nama' => 'Dr. Aris Sugiharto, S.Si., M.Kom.', 'email' => 'aris.sugiharto@gmail.com', 'no_telp' => '08123456009'],
            ['nip' => '1234567810', 'nama' => 'Suparno, S.Ag., M.S.I.', 'email' => 'suparno@gmail.com', 'no_telp' => '08123456010'],
            ['nip' => '1234567811', 'nama' => 'Rismiyati, B.Eng, M.Cs.', 'email' => 'rismiyati@gmail.com', 'no_telp' => '08123456011'],
            ['nip' => '1234567812', 'nama' => 'Muhammad Malik Hakim, S.T., M.T.I.', 'email' => 'malik.hakim@gmail.com', 'no_telp' => '08123456012'],
            ['nip' => '1234567813', 'nama' => 'Dr. Rahmat Hidayat, S.Si., M.T.', 'email' => 'rahmat.hidayat@gmail.com', 'no_telp' => '08123456013'],
            ['nip' => '1234567814', 'nama' => 'Dra. Sri Puji Astuti, M.Pd.', 'email' => 'puji.astuti@gmail.com', 'no_telp' => '08123456014'],
        ];

        DB::table('dosen')->insert($dosen);
    }
}
