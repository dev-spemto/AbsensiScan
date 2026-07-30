<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengurusKelas extends Model
{
    protected $table = 'pengurus_kelas';

    protected $fillable = [

        'kelas_id',

        'ketua_siswa_id',
        'ketua_user_id',

        'wakil_siswa_id',
        'wakil_user_id',

        'sekretaris_siswa_id',
        'sekretaris_user_id',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Kelas
    |--------------------------------------------------------------------------
    */

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Ketua
    |--------------------------------------------------------------------------
    */

    public function ketua()
    {
        return $this->belongsTo(Siswa::class, 'ketua_siswa_id');
    }

    public function ketuaUser()
    {
        return $this->belongsTo(User::class, 'ketua_user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Wakil
    |--------------------------------------------------------------------------
    */

    public function wakil()
    {
        return $this->belongsTo(Siswa::class, 'wakil_siswa_id');
    }

    public function wakilUser()
    {
        return $this->belongsTo(User::class, 'wakil_user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Sekretaris
    |--------------------------------------------------------------------------
    */

    public function sekretaris()
    {
        return $this->belongsTo(Siswa::class, 'sekretaris_siswa_id');
    }

    public function sekretarisUser()
    {
        return $this->belongsTo(User::class, 'sekretaris_user_id');
    }
}