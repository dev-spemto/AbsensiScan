<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PengurusKelas;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nisn',
        'barcode',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kelas_id',
        'jabatan',
        'foto',
        'aktif',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    public function ketuaPengurus()
    {
        return $this->hasOne(PengurusKelas::class, 'ketua_siswa_id');
    }

    public function wakilPengurus()
    {
        return $this->hasOne(PengurusKelas::class, 'wakil_siswa_id');
    }

    public function sekretarisPengurus()
    {
        return $this->hasOne(PengurusKelas::class, 'sekretaris_siswa_id');
    }
}