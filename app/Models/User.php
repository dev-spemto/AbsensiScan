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

        'siswa_id',

    ];

    protected $hidden = [

        'password',

        'remember_token',

    ];

    protected $casts = [

        'aktif' => 'boolean',

    ];

    /**
     * Relasi Guru
     */
    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    /**
     * Relasi Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Administrator
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Guru
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Ketua Kelas
     */
    public function isKetuaKelas(): bool
    {
        return $this->role === 'ketua_kelas';
    }

    /**
     * Wakil Kelas
     */
    public function isWakilKelas(): bool
    {
        return $this->role === 'wakil_kelas';
    }

    /**
     * Sekretaris
     */
    public function isSekretaris(): bool
    {
        return $this->role === 'sekretaris';
    }

    /**
     * Semua Petugas Presensi
     */
    public function isPetugasPresensi(): bool
    {
        return in_array($this->role, [

            'guru',

            'ketua_kelas',

            'wakil_kelas',

            'sekretaris',

        ]);
    }

    /**
     * Guru atau Admin
     */
    public function isGuruAtauAdmin(): bool
    {
        return in_array($this->role, [

            'admin',

            'guru',

        ]);
    }

    /**
     * Akun Aktif
     */
    public function isAktif(): bool
    {
        return $this->aktif;
    }
}