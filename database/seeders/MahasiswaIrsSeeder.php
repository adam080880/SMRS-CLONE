<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Irs;

class MahasiswaIrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allMahasiswa = DB::table('mahasiswa')->get();
        $mahasiswaIRSSeeder = [];
        $mahasiswaIRSDetailSeeder = [];
        $generateKhsRandomSeeder = [];
        $nilaiOptions = ['A', 'B'];
        $bobot = [
            'A' => 4,
            'B' => 3,
        ];

        $irsBySemester = [];
        $allIrs = DB::table('irs')->get();

        foreach ($allIrs as $irs) {
            $irsBySemester[$irs->semester][] = $irs;
        };

        $startGeneratedMahasiswaIRSID = 1;

        foreach ($allMahasiswa as $mahasiswa) {
            for ($i = 0; $i < $mahasiswa->semester_berjalan; $i++) {
                $semesterSeeder = $i + 1;

                if (!isset($irsBySemester[$semesterSeeder]) || $semesterSeeder >= $mahasiswa->semester_berjalan) {
                    continue;
                }

                $replaceStatus = 'Belum Diapprove';

                if ($semesterSeeder < $mahasiswa->semester_berjalan) {
                    $replaceStatus = 'Approved';
                }

                $mahasiswaIrsId = $startGeneratedMahasiswaIRSID + 1;
                $startGeneratedMahasiswaIRSID += 1;

                $mahasiswaIRSSeeder[] = [
                    'id' => $mahasiswaIrsId,
                    'nim' => $mahasiswa->nim,
                    'status' => $replaceStatus,
                    'semester' => $semesterSeeder,
                ];

                foreach ($irsBySemester[$semesterSeeder] as $availIrsOnThisSemster) {
                    $mahasiswaIRSDetailSeeder[] = [
                        'mahasiswa_irs_id' => $mahasiswaIrsId,
                        'kode_irs' => $availIrsOnThisSemster->kode
                    ];

                    $nilai = $nilaiOptions[array_rand($nilaiOptions)];

                    $generateKhsRandomSeeder[] = [
                        'nim' => $mahasiswa->nim,
                        'nilai' => $nilai,
                        'bobot' => $bobot[$nilai],
                        'kode' => $availIrsOnThisSemster->kode,
                        'semester' => $semesterSeeder,
                    ];
                }
            }
        }

        DB::table('mahasiswa_irs')->insert($mahasiswaIRSSeeder);
        DB::table('mahasiswa_irs_detail')->insert($mahasiswaIRSDetailSeeder);
        DB::table('khs')->insert($generateKhsRandomSeeder);
    }
}
