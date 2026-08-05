<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Throwable;

class GuruDashboardController extends Controller
{
    public function index()
    {
        try {

            $guru = Guru::select(
                    'id',
                    'user_id',
                    'nama'
                )
                ->where('user_id', Auth::id())
                ->first();

            if (!$guru) {

                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Data guru tidak ditemukan.'
                    );

            }

            $presensiHariIni = Presensi::where(
                    'guru_id',
                    $guru->id
                )
                ->whereDate(
                    'tanggal',
                    today()
                )
                ->count();

            $presensiTerbaru = Presensi::with([
                    'siswa.kelas'
                ])
                ->where(
                    'guru_id',
                    $guru->id
                )
                ->latest()
                ->take(10)
                ->get();

            return view(
                'guru.dashboard',
                compact(
                    'guru',
                    'presensiHariIni',
                    'presensiTerbaru'
                )
            );

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat memuat dashboard guru.'
            );

        }
    }
}