<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Izin;
use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
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
            'scanner',
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

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas);
            });
        }

        if ($request->filled('siswa')) {
            $query->where('siswa_id', $request->siswa);
        }

        if ($request->filled('guru')) {
            $query->where('guru_id', $request->guru);
        }

        if ($request->filled('scanner')) {
            $query->where('scanner_id', $request->scanner);
        }

        if ($request->filled('scan_by')) {
            $query->where('scan_by', $request->scan_by);
        }

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalData = (clone $query)->count();

        $hadir = (clone $query)
            ->where('status', 'Hadir')
            ->count();

        $terlambat = (clone $query)
            ->where('status', 'Terlambat')
            ->count();

        $izin = (clone $query)
            ->where('status', 'Izin')
            ->count();

        $sakit = (clone $query)
            ->where('status', 'Sakit')
            ->count();

        $alpha = (clone $query)
            ->where('status', 'Alpha')
            ->count();

        $izinDisetujui = Izin::where('status', 'Disetujui')->get();    

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $presensis = (clone $query)
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

            'izinDisetujui' => $izinDisetujui,

            'kelas' => Kelas::orderBy('tingkat')
                ->orderBy('nama_kelas')
                ->get(),

            'gurus' => Guru::where('aktif', true)
                ->orderBy('nama')
                ->get(),

            'scanners' => User::orderBy('nama')
                ->get(),

            'scanRoles' => [
                'admin' => 'Admin',
                'guru' => 'Guru',
                'ketua_kelas' => 'Ketua Kelas',
                'sekretaris' => 'Sekretaris',
            ],

            'siswas' => Siswa::orderBy('nama')
                ->get(),

            'tahunAjarans' => TahunAjaran::orderByDesc('id')
                ->get(),

            'pengaturan' => Pengaturan::first(),

            'totalData' => $totalData,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha,

        ]);
    }
}