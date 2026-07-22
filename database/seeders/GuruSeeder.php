<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Guru::updateOrCreate(

            [

                'nip' => '19800101001',

            ],

            [

                'nama' => 'Administrator',

                'username' => 'admin',

                'password' => Hash::make('admin123'),

                'aktif' => true,

            ]

        );

        User::updateOrCreate(

            [

                'username' => $guru->username,

            ],

            [

                'nama' => $guru->nama,

                'password' => $guru->password,

                'role' => 'admin',

                'aktif' => true,

            ]

        );
    }
}