<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pengaturan;
use App\Models\Presensi;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalSiswa = Siswa::count();

        $totalGuru = Guru::count();

        $totalKelas = \App\Models\Kelas::count();

        $belumPresensiHariIni = $totalSiswa - $totalScanHariIni;

        $presensiHariIni = Presensi::whereDate('tanggal', today());

        $hadirHariIni = (clone $presensiHariIni)
            ->where('status', 'Hadir')
            ->count();

        $terlambatHariIni = (clone $presensiHariIni)
            ->where('status', 'Terlambat')
            ->count();

        $izinHariIni = (clone $presensiHariIni)
            ->where('status', 'Izin')
            ->count();

        $sakitHariIni = (clone $presensiHariIni)
            ->where('status', 'Sakit')
            ->count();

        $alphaHariIni = (clone $presensiHariIni)
            ->where('status', 'Alpha')
            ->count();

        $totalScanHariIni = (clone $presensiHariIni)->count();

        /*
        |--------------------------------------------------------------------------
        | Presensi Terbaru
        |--------------------------------------------------------------------------
        */

        $presensiTerakhir = Presensi::with([
                'siswa.kelas',
                'scanner',
            ])
            ->latest()
            ->take(10)
            ->get();

        $presensiTerbaru = $presensiTerakhir->first();

        /*
        |--------------------------------------------------------------------------
        | Grafik 7 Hari (Tahap 35)
        |--------------------------------------------------------------------------
        */

        $grafikMingguan = Presensi::select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->whereDate('tanggal', '>=', Carbon::now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('dashboard', compact(

            'pengaturan',

            'totalSiswa',

            'totalGuru',

            'totalKelas'

            'hadirHariIni',

            'terlambatHariIni',

            'izinHariIni',

            'sakitHariIni',

            'alphaHariIni',

            'totalScanHariIni',

            'belumPresensiHariIni'

            'presensiTerakhir',

            'presensiTerbaru',

            'grafikMingguan'

        ));
    }
}