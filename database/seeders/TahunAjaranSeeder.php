<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tahun_ajarans')->insert([
            'tahun' => '2026/2027',
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}