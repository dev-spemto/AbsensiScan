<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $fillable = [
        'tahun',
        'aktif',
    ];

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }
}