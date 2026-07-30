<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    /**
     * Simpan aktivitas user
     */
    public static function store(
        string $aktivitas,
        ?string $modul = null
    ): void {

        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();

        ActivityLog::create([

            'user_id'    => $user->id,

            'nama'       => $user->nama,

            'role'       => $user->role,

            'aktivitas'  => $aktivitas,

            'modul'      => $modul,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

            'waktu'      => now(),

        ]);
    }
}