<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'logo',
        'jam_masuk',
        'batas_terlambat',
        'scan_mulai',
        'scan_selesai',
        'timezone',
        'aktifkan_foto',
        'aktifkan_suara',
    ];
}