<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    /**
     * Daftar Presensi
     */
    public function index(Request $request)
    {
        $query = Presensi::with([
            'siswa.kelas',
            'guru',
            'tahunAjaran'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal')) {

            $query->whereDate('tanggal', $request->tanggal);

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Nama Siswa
        |--------------------------------------------------------------------------
        */

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->whereHas('siswa', function ($q) use ($keyword) {

                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nisn', 'like', "%{$keyword}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        $presensis = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('presensi.index', compact('presensis'));
    }

    /**
     * Halaman Scan Presensi
     */
    public function create()
    {
        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        $riwayat = Presensi::with([
                'siswa.kelas'
            ])
            ->whereDate('tanggal', today())
            ->latest('jam_scan')
            ->get();

        return view('presensi.create', compact(
            'tahunAjaran',
            'riwayat'
        ));
    }

    /**
     * Simpan Manual (Cadangan)
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'guru_id' => 'required|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'tanggal' => 'required|date',
            'jam_scan' => 'required',
            'status' => 'required',
            'metode' => 'required',
            'keterangan' => 'nullable',
            'device_name' => 'nullable',
        ]);

        Presensi::create($request->all());

        return redirect()
            ->route('presensi.index')
            ->with('success', 'Data presensi berhasil ditambahkan.');
    }

    /**
     * Scan Barcode
     */
    public function scan(Request $request)
    {
        $request->validate([
            'barcode' => 'required'
        ]);

        $barcode = trim($request->barcode);

        $siswa = Siswa::with('kelas')
            ->where('barcode', $barcode)
            ->orWhere('nisn', $barcode)
            ->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan.'
            ]);
        }

        if (!$siswa->aktif) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa sudah tidak aktif.'
            ]);
        }

        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        if (!$tahunAjaran) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada Tahun Ajaran aktif.'
            ]);
        }

        $presensiHariIni = Presensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', today())
            ->first();

        if ($presensiHariIni) {
            return response()->json([
                'success' => false,
                'message' => $siswa->nama . ' sudah melakukan presensi hari ini.'
            ]);
        }

        $jamSekarang = now();

        $status = $jamSekarang->format('H:i') <= '07:00'
            ? 'Hadir'
            : 'Terlambat';

        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'guru_id' => auth()->id(),
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tanggal' => today(),
            'jam_scan' => $jamSekarang->format('H:i:s'),
            'status' => $status,
            'metode' => 'Barcode',
            'device_name' => request()->userAgent(),
            'keterangan' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil.',
            'id' => $presensi->id,
            'nama' => $siswa->nama,
            'kelas' => $siswa->kelas->nama_lengkap,
            'status' => $status,
            'jam' => $presensi->jam_scan,
            'tanggal' => $presensi->tanggal,
            'foto' => $siswa->foto
                ? asset('storage/' . $siswa->foto)
                : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&size=200',
        ]);
    }

    /**
     * Detail Presensi
     */
    public function show(Presensi $presensi)
    {
        return view('presensi.show', compact('presensi'));
    }

    /**
     * Form Edit
     */
    public function edit(Presensi $presensi)
    {
        $siswas = Siswa::orderBy('nama')->get();

        $gurus = Guru::where('aktif', true)
            ->orderBy('nama')
            ->get();

        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        return view('presensi.edit', compact(
            'presensi',
            'siswas',
            'gurus',
            'tahunAjarans'
        ));
    }

    /**
     * Update Presensi
     */
    public function update(Request $request, Presensi $presensi)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'guru_id' => 'required|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'tanggal' => 'required|date',
            'jam_scan' => 'required',
            'status' => 'required',
            'metode' => 'required',
            'keterangan' => 'nullable',
            'device_name' => 'nullable',
        ]);

        $presensi->update($request->all());

        return redirect()
            ->route('presensi.index')
            ->with('success', 'Data presensi berhasil diperbarui.');
    }

    /**
     * Hapus Presensi
     */
    public function destroy(Presensi $presensi)
    {
        $presensi->delete();

        return redirect()
            ->route('presensi.index')
            ->with('success', 'Data presensi berhasil dihapus.');
    }
}