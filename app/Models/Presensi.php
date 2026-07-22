<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    protected $table = 'presensis';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tahun_ajaran_id',
        'tanggal',
        'jam_scan',
        'status',
        'metode',
        'keterangan',
        'device_name',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke Siswa
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi ke Guru
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Relasi ke Tahun Ajaran
     */
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}