<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            KelasSeeder::class,

            PengaturanSeeder::class,

            TahunAjaranSeeder::class,

            GuruSeeder::class,

        ]);

        User::updateOrCreate(

            [

                'username' => 'admin',

            ],

            [

                'nama' => 'Administrator',

                'password' => Hash::make('admin123'),

                'role' => 'admin',

                'aktif' => true,

            ]

        );
    }
}