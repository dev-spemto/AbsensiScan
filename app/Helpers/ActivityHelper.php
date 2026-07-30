<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
    public static function log(
        string $aktivitas,
        string $modul,
        string $keterangan = ''
    ): void {

        ActivityLog::create([

            'user_id'    => Auth::id(),

            'nama'       => Auth::user()->nama ?? '-',

            'role'       => Auth::user()->role ?? '-',

            'aktivitas'  => $aktivitas,

            'modul'      => $modul,

            'keterangan' => $keterangan,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }
}