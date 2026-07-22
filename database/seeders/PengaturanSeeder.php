<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengaturans')->insert([
            'nama_sekolah' => 'SMP Muhammadiyah Tonjong',
            'logo' => null,
            'jam_masuk' => '07:00:00',
            'batas_terlambat' => '07:10:00',
            'scan_mulai' => '06:30:00',
            'scan_selesai' => '08:00:00',
            'timezone' => 'Asia/Jakarta',
            'aktifkan_foto' => true,
            'aktifkan_suara' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}