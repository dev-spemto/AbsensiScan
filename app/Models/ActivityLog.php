<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [

        'user_id',

        'nama',

        'role',

        'aktivitas',

        'modul',

        'ip_address',

        'user_agent',

        'waktu',

    ];

    protected $casts = [

        'waktu' => 'datetime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}