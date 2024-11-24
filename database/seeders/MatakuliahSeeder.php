<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mata_kuliah')->insert([
            ['kodemk' => 'PAIK6102', 'nama' => 'Dasar Pemrograman', 'program_studi' =>'Informatika', 'plotsemester' => 1, 'sks' => 3, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAIK6105', 'nama' => 'Struktur Diskrit', 'program_studi' =>'Informatika', 'plotsemester' => 1, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAIK6301', 'nama' => 'Struktur Data', 'program_studi' =>'Informatika', 'plotsemester' => 3, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAIK6302', 'nama' => 'Sistem Operasi', 'program_studi' =>'Informatika', 'plotsemester' => 3, 'sks' => 3, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAIK6202', 'nama' => 'Algoritma dan Pemrograman', 'program_studi' =>'Informatika', 'plotsemester' => 2, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAIK6501', 'nama' => 'Pengembangan Berbasis Platform', 'program_studi' =>'Informatika', 'plotsemester' => 5, 'sks' => 3, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAFS6321', 'nama' => 'Fisika Dasar II', 'program_studi' => 'Fisika', 'plotsemester' => 2, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAFS6322', 'nama' => 'Praktikum Fisika Dasar II', 'program_studi' => 'Fisika', 'plotsemester' => 2, 'sks' => 1, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAFS6323', 'nama' => 'Fisika Matematika I', 'program_studi' => 'Fisika', 'plotsemester' => 2, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAFS6324', 'nama' => 'Termodinamika', 'program_studi' => 'Fisika', 'plotsemester' => 2, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PAFS6325', 'nama' => 'Gelombang', 'program_studi' => 'Fisika', 'plotsemester' => 2, 'sks' => 2, 'sifat' => 'W', 'jumlah_kelas' => 4],


            // Keperluan dataset irs
            ['kodemk' => 'STRDAT01', 'nama' => 'Struktur Data 1', 'program_studi' =>'Informatika', 'plotsemester' => 1, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PEMDAS01', 'nama' => 'Dasar Pemrograman 1', 'program_studi' =>'Informatika', 'plotsemester' => 1, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'STRDAT02', 'nama' => 'Struktur Data 2', 'program_studi' =>'Informatika', 'plotsemester' => 2, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PEMDAS02', 'nama' => 'Dasar Pemrograman 2', 'program_studi' =>'Informatika', 'plotsemester' => 2, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'STRDAT03', 'nama' => 'Struktur Data 3', 'program_studi' =>'Informatika', 'plotsemester' => 3, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PEMDAS03', 'nama' => 'Dasar Pemrograman 3', 'program_studi' =>'Informatika', 'plotsemester' => 3, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'STRDAT04', 'nama' => 'Struktur Data 4', 'program_studi' =>'Informatika', 'plotsemester' => 4, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PEMDAS04', 'nama' => 'Dasar Pemrograman 4', 'program_studi' =>'Informatika', 'plotsemester' => 4, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'STRDAT05', 'nama' => 'Struktur Data 5', 'program_studi' =>'Informatika', 'plotsemester' => 5, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'PEMDAS05', 'nama' => 'Dasar Pemrograman 5', 'program_studi' =>'Informatika', 'plotsemester' => 5, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'DEEPLN05', 'nama' => 'Deep Learning', 'program_studi' =>'Informatika', 'plotsemester' => 5, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'MLLN0005', 'nama' => 'Machine Learning', 'program_studi' =>'Informatika', 'plotsemester' => 5, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
            ['kodemk' => 'TPLA0005', 'nama' => 'Topologi Jaringan Advanced', 'program_studi' =>'Informatika', 'plotsemester' => 5, 'sks' => 4, 'sifat' => 'W', 'jumlah_kelas' => 4],
        ]);
    }
}