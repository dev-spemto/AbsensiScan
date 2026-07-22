<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [

        'nama',

        'username',

        'password',

        'role',

        'aktif',

    ];

    protected $hidden = [

        'password',

        'remember_token',

    ];

    protected $casts = [

        'password' => 'hashed',

        'aktif' => 'boolean',

    ];

    /**
     * Cek apakah user Administrator
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user Guru
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Cek apakah akun aktif
     */
    public function isAktif(): bool
    {
        return $this->aktif;
    }
}