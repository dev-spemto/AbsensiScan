<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\TahunAjaran;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik Master
        |--------------------------------------------------------------------------
        */

        $totalSiswa = Siswa::count();
        $totalGuru  = Guru::where('aktif', true)->count();
        $totalKelas = Kelas::count();

        /*
        |--------------------------------------------------------------------------
        | Tahun Ajaran Aktif
        |--------------------------------------------------------------------------
        */

        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        /*
        |--------------------------------------------------------------------------
        | Statistik Presensi Hari Ini
        |--------------------------------------------------------------------------
        */

        $hariIni = Carbon::today();

        $hadirHariIni = Presensi::whereDate('tanggal', $hariIni)
            ->where('status', 'Hadir')
            ->count();

        $terlambatHariIni = Presensi::whereDate('tanggal', $hariIni)
            ->where('status', 'Terlambat')
            ->count();

        $izinHariIni = Presensi::whereDate('tanggal', $hariIni)
            ->where('status', 'Izin')
            ->count();

        $sakitHariIni = Presensi::whereDate('tanggal', $hariIni)
            ->where('status', 'Sakit')
            ->count();

        $alphaHariIni = Presensi::whereDate('tanggal', $hariIni)
            ->where('status', 'Alpha')
            ->count();

        $presensiHariIni = Presensi::whereDate('tanggal', $hariIni)->count();

        /*
        |--------------------------------------------------------------------------
        | Riwayat Scan Terbaru
        |--------------------------------------------------------------------------
        */

        $presensiTerbaru = Presensi::with([
                'siswa.kelas',
                'guru'
            ])
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Kirim ke View
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'tahunAjaran',

            'presensiHariIni',
            'hadirHariIni',
            'terlambatHariIni',
            'izinHariIni',
            'sakitHariIni',
            'alphaHariIni',

            'presensiTerbaru'
        ));
    }
}