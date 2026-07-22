<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Presensi;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    /**
     * Halaman Rekap Presensi
     */
    public function index(Request $request)
    {
        $query = Presensi::with([
            'siswa.kelas',
            'guru',
            'tahunAjaran',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal')) {

            $query->whereDate('tanggal', $request->tanggal);

        }

        if ($request->filled('kelas')) {

            $query->whereHas('siswa', function ($q) use ($request) {

                $q->where('kelas_id', $request->kelas);

            });

        }

        if ($request->filled('guru')) {

            $query->where('guru_id', $request->guru);

        }

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        /*
        |--------------------------------------------------------------------------
        | Clone Query untuk Statistik
        |--------------------------------------------------------------------------
        */

        $statistik = clone $query;

        $totalData = $statistik->count();

        $hadir = (clone $query)->where('status', 'Hadir')->count();

        $terlambat = (clone $query)->where('status', 'Terlambat')->count();

        $izin = (clone $query)->where('status', 'Izin')->count();

        $sakit = (clone $query)->where('status', 'Sakit')->count();

        $alpha = (clone $query)->where('status', 'Alpha')->count();

        /*
        |--------------------------------------------------------------------------
        | Data Tabel
        |--------------------------------------------------------------------------
        */

        $presensis = $query
            ->latest('tanggal')
            ->latest('jam_scan')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('rekap.index', [

            'presensis' => $presensis,

            'kelas' => Kelas::orderBy('tingkat')
                ->orderBy('nama_kelas')
                ->get(),

            'gurus' => Guru::where('aktif', true)
                ->orderBy('nama')
                ->get(),

            'totalData' => $totalData,

            'hadir' => $hadir,

            'terlambat' => $terlambat,

            'izin' => $izin,

            'sakit' => $sakit,

            'alpha' => $alpha,

        ]);
    }
}