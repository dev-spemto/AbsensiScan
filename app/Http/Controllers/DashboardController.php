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
        | Tanggal Hari Ini
        |--------------------------------------------------------------------------
        */

        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Statistik Master
        |--------------------------------------------------------------------------
        */

        $totalSiswa = Siswa::where('aktif', true)->count();

        $totalGuru = Guru::where('aktif', true)->count();

        $totalKelas = Kelas::count();

        /*
        |--------------------------------------------------------------------------
        | Presensi Hari Ini
        |--------------------------------------------------------------------------
        */

        $presensiHariIni = Presensi::whereDate('tanggal', $today);

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

        /*
        |--------------------------------------------------------------------------
        | Total Scan
        |--------------------------------------------------------------------------
        */

        $totalScanHariIni = (clone $presensiHariIni)->count();

        $belumPresensiHariIni = max(
            0,
            $totalSiswa - $totalScanHariIni
        );

        /*
        |--------------------------------------------------------------------------
        | Persentase Kehadiran
        |--------------------------------------------------------------------------
        */

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
            ->whereDate('tanggal', $today)
            ->latest('jam_scan')
            ->take(10)
            ->get();

        $presensiTerbaru = $presensiTerakhir->first();

        $presensiTerakhir = $presensiTerakhir
            ->sortByDesc(function ($item) {
                return $item->tanggal . ' ' . $item->jam_scan;
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Grafik Presensi 7 Hari
        |--------------------------------------------------------------------------
        */

        $grafikMingguan = collect();

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::today()->subDays($i);

            $grafikMingguan->push([

                'tanggal' => $tanggal->format('d M'),

                'hadir' => Presensi::whereDate('tanggal', $tanggal)
                    ->where('status', 'Hadir')
                    ->count(),

                'terlambat' => Presensi::whereDate('tanggal', $tanggal)
                    ->where('status', 'Terlambat')
                    ->count(),

                'izin' => Presensi::whereDate('tanggal', $tanggal)
                    ->where('status', 'Izin')
                    ->count(),

                'sakit' => Presensi::whereDate('tanggal', $tanggal)
                    ->where('status', 'Sakit')
                    ->count(),

                'alpha' => Presensi::whereDate('tanggal', $tanggal)
                    ->where('status', 'Alpha')
                    ->count(),

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Kelas Teraktif Hari Ini
        |--------------------------------------------------------------------------
        */

        $kelasTeraktif = Kelas::withCount([
                'siswas as hadir_hari_ini' => function ($query) use ($today) {

                    $query->whereHas('presensis', function ($presensi) use ($today) {

                        $presensi->whereDate('tanggal', $today);

                    });

                }
            ])
            ->orderByDesc('hadir_hari_ini')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Statistik Bulan Berjalan
        |--------------------------------------------------------------------------
        */

        $presensiBulanIni = Presensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);

        $hadirBulanIni = (clone $presensiBulanIni)
            ->where('status', 'Hadir')
            ->count();

        $terlambatBulanIni = (clone $presensiBulanIni)
            ->where('status', 'Terlambat')
            ->count();

        $izinBulanIni = (clone $presensiBulanIni)
            ->where('status', 'Izin')
            ->count();

        $sakitBulanIni = (clone $presensiBulanIni)
            ->where('status', 'Sakit')
            ->count();

        $alphaBulanIni = (clone $presensiBulanIni)
            ->where('status', 'Alpha')
            ->count();

        $hour = now(
            $pengaturan?->timezone ?? config('app.timezone')
        )->hour;

        if ($hour < 11) {
            $greeting = 'Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Siang';
        } elseif ($hour < 18) {
            $greeting = 'Sore';
        } else {
            $greeting = 'Malam';
        }

        return view('dashboard', compact(

            'pengaturan',
            
            'greeting',

            'totalSiswa',
            'totalGuru',
            'totalKelas',

            'hadirHariIni',
            'terlambatHariIni',
            'izinHariIni',
            'sakitHariIni',
            'alphaHariIni',

            'totalScanHariIni',
            'belumPresensiHariIni',
            'persentaseHadir',

            'presensiTerbaru',
            'presensiTerakhir',

            'grafikMingguan',

            'kelasTeraktif',

            'hadirBulanIni',
            'terlambatBulanIni',
            'izinBulanIni',
            'sakitBulanIni',
            'alphaBulanIni'

        ));
    }
}