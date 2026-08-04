<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pengaturan;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Kelas;
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

        $belumPresensiHariIni = $totalSiswa - $totalScanHariIni;

        if ($belumPresensiHariIni < 0) {
            $belumPresensiHariIni = 0;
        }

        $persentaseHadir = $totalSiswa > 0
            ? round(($totalScanHariIni / $totalSiswa) * 100, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Presensi Terbaru
        |--------------------------------------------------------------------------
        */

        $presensiTerakhir = Presensi::with([
                'siswa.kelas',
                'scanner',
            ])
            ->whereDate('tanggal', today())
            ->latest('jam_scan')
            ->take(10)
            ->get();

        $presensiTerbaru = $presensiTerakhir->first();

        $presensiTerakhir = $presensiTerakhir->sortByDesc(function ($item) {
            return $item->tanggal.' '.$item->jam_scan;
        })->values();

        /*
        |--------------------------------------------------------------------------
        | Grafik 7 Hari (Tahap 35)
        |--------------------------------------------------------------------------
        */

        $kelasTeraktif = Kelas::withCount([
            'siswas as hadir_hari_ini' => function ($q) {
                $q->whereHas('presensis', function ($p) {
                    $p->whereDate('tanggal', today());
                });
            }
        ])
        ->orderByDesc('hadir_hari_ini')
        ->first();
        
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

            'totalKelas',

            'hadirHariIni',

            'terlambatHariIni',

            'izinHariIni',

            'sakitHariIni',

            'alphaHariIni',

            'totalScanHariIni',

            'persentaseHadir',

            'belumPresensiHariIni',

            'presensiTerakhir',

            'presensiTerbaru',

            'grafikMingguan',

            'kelasTeraktif',

        ));
    }
}