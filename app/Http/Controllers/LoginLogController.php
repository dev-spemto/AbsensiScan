<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Throwable;

class LoginLogController extends Controller
{
    /**
     * Daftar Riwayat Login
     */
    public function index(Request $request)
    {
        $request->validate([
            'tanggal' => 'nullable|date',
            'search'  => 'nullable|string|max:100',
        ]);

        try {

            $query = LoginLog::query();

            /*
            |--------------------------------------------------------------------------
            | Filter Tanggal
            |--------------------------------------------------------------------------
            */

            if ($request->filled('tanggal')) {

                $query->whereDate(
                    'login_at',
                    $request->tanggal
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Pencarian
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");

                });

            }

            $logs = $query
                ->latest('login_at')
                ->paginate(20)
                ->withQueryString();

            return view(
                'login-log.index',
                compact('logs')
            );

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat memuat riwayat login.'
            );

        }
    }
}