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

        'aktif' => 'boolean',

    ];


    /**
     * Relasi ke data guru
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }


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