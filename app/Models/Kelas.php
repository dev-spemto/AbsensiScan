<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'tingkat',
        'nama_kelas',
    ];

    /**
     * Relasi ke tabel siswa
     */
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function pengurus(): HasOne
    {
        return $this->hasOne(PengurusKelas::class);
    }

    /**
     * Accessor nama kelas lengkap.
     * Contoh:
     * 7 + A = 7A
     * 8 + B = 8B
     */
    public function getNamaLengkapAttribute(): string
    {
        return "{$this->tingkat}{$this->nama_kelas}";
    }
}