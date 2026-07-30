<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\PengurusKelas;
use Illuminate\Database\Seeder;

class PengurusKelasSeeder extends Seeder
{
    /**
     * Seed data pengurus kelas.
     */
    public function run(): void
    {
        $kelasList = Kelas::orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        foreach ($kelasList as $kelas) {

            PengurusKelas::firstOrCreate(

                [
                    'kelas_id' => $kelas->id,
                ],

                [
                    'ketua_siswa_id'      => null,
                    'ketua_user_id'       => null,

                    'wakil_siswa_id'      => null,
                    'wakil_user_id'       => null,

                    'sekretaris_siswa_id' => null,
                    'sekretaris_user_id'  => null,
                ]

            );

        }
    }
}