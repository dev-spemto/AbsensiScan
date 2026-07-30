<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class GuruDashboardController extends Controller
{
    public function index()
    {

        $guru = Guru::where('user_id', Auth::id())
            ->first();


        $presensiHariIni = Presensi::where('guru_id', $guru->id ?? 0)
            ->whereDate('tanggal', today())
            ->count();


        $presensiTerbaru = Presensi::with([
            'siswa.kelas'
        ])
        ->where('guru_id', $guru->id ?? 0)
        ->latest()
        ->take(10)
        ->get();


        return view('guru.dashboard', compact(
            'guru',
            'presensiHariIni',
            'presensiTerbaru'
        ));

    }
}