<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kelas')->insert([
            ['tingkat'=>7,'nama_kelas'=>'A'],
            ['tingkat'=>7,'nama_kelas'=>'B'],
            ['tingkat'=>7,'nama_kelas'=>'C'],
            
            ['tingkat'=>8,'nama_kelas'=>'A'],
            ['tingkat'=>8,'nama_kelas'=>'B'],
            ['tingkat'=>8,'nama_kelas'=>'C'],
            
            ['tingkat'=>9,'nama_kelas'=>'A'],
            ['tingkat'=>9,'nama_kelas'=>'B'],
            ['tingkat'=>9,'nama_kelas'=>'C'],
]);
    }
}