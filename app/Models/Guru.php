<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Authenticatable
{
    use Notifiable;

    protected $table = 'gurus';

    protected $fillable = [

        'nip',

        'nama',

        'tempat_lahir',

        'tanggal_lahir',

        'jenis_kelamin',

        'no_hp',

        'email',

        'alamat',

        'foto',

        'username',

        'password',

        'aktif',

    ];

    protected $hidden = [

        'password',

        'remember_token',

    ];

    protected $casts = [

        'tanggal_lahir' => 'date',

        'aktif' => 'boolean',

        'password' => 'hashed',

    ];

    /**
     * Relasi Presensi
     */
    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    /**
     * Cek akun aktif
     */
    public function isAktif(): bool
    {
        return $this->aktif;
    }
}