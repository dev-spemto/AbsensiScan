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
        // Buat akun login guru/admin
        $user = User::updateOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'nama' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'aktif' => true,
            ]
        );


        // Buat data profil guru
        Guru::updateOrCreate(
            [
                'nip' => '19800101001',
            ],
            [
                'user_id' => $user->id,
                'nama' => 'Administrator',
                'aktif' => true,
            ]
        );
    }
}