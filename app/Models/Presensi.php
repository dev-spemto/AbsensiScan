<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Presensi extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Status Presensi
    |--------------------------------------------------------------------------
    */

    public const STATUS_HADIR = 'Hadir';

    public const STATUS_TERLAMBAT = 'Terlambat';

    public const STATUS_IZIN = 'Izin';

    public const STATUS_SAKIT = 'Sakit';

    public const STATUS_ALPHA = 'Alpha';

    /*
    |--------------------------------------------------------------------------
    | Metode Presensi
    |--------------------------------------------------------------------------
    */

    public const METODE_BARCODE = 'Barcode';

    public const METODE_MANUAL = 'Manual';
    
    protected $table = 'presensis';

    protected $fillable = [

        'siswa_id',

        'guru_id',

        'scanner_id',

        'scan_by',

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

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanner_id');
    }
}