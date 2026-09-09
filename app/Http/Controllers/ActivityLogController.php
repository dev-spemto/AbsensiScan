<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;

class ActivityLogController extends Controller
{
    /**
     * Daftar Activity Log
     */
    public function index(Request $request)
    {
        $request->validate([
            'search'  => 'nullable|string|max:100',
            'user'    => 'nullable|integer|exists:users,id',
            'modul'   => 'nullable|string|max:100',
            'tanggal' => 'nullable|date',
        ]);

        try {

            $query = ActivityLog::with('user');

            /*
            |--------------------------------------------------------------------------
            | Pencarian
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('aktivitas', 'like', "%{$search}%")
                        ->orWhere('modul', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($user) use ($search) {

                            $user->where(
                                'nama',
                                'like',
                                "%{$search}%"
                            );

                        });

                });

            }

            /*
            |--------------------------------------------------------------------------
            | Filter User
            |--------------------------------------------------------------------------
            */

            if ($request->filled('user')) {
                $query->where('user_id', $request->user);
            }

            /*
            |--------------------------------------------------------------------------
            | Filter Modul
            |--------------------------------------------------------------------------
            */

            if ($request->filled('modul')) {
                $query->where('modul', $request->modul);
            }

            /*
            |--------------------------------------------------------------------------
            | Filter Tanggal
            |--------------------------------------------------------------------------
            */

            if ($request->filled('tanggal')) {

                $query->whereDate(
                    'created_at',
                    $request->tanggal
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Data
            |--------------------------------------------------------------------------
            */

            $logs = $query
                ->latest()
                ->paginate(20)
                ->withQueryString();

            $users = User::select('id', 'nama')
                ->orderBy('nama')
                ->get();

            $moduls = ActivityLog::select('modul')
                ->distinct()
                ->orderBy('modul')
                ->pluck('modul');

            return view('activity-log.index', compact(

                'logs',
                'users',
                'moduls'

            ));

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat memuat Activity Log.'
            );

        }
    }
}