<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model
{
    protected $table = 'gurus';

    protected $fillable = [

        'user_id',

        'nip',

        'nama',

        'tempat_lahir',

        'tanggal_lahir',

        'jenis_kelamin',

        'no_hp',

        'email',

        'alamat',

        'foto',

        'aktif',

    ];


    protected $casts = [

        'tanggal_lahir' => 'date',

        'aktif' => 'boolean',

    ];


    /**
     * Relasi ke akun login
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Relasi Presensi
     */
    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }


    /**
     * Cek guru aktif
     */
    public function isAktif(): bool
    {
        return $this->aktif;
    }
}