<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pengaturan;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Helpers\ActivityHelper;

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
        'scanner',
        'tahunAjaran',
    ]);

    $gurus = Guru::where('aktif', true)
        ->orderBy('nama')
        ->get();

    $scanner = \App\Models\User::orderBy('nama')
        ->get();

        if ($request->filled('tanggal')) {

            $query->whereDate('tanggal', $request->tanggal);

        }

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->whereHas('siswa', function ($q) use ($keyword) {

                $q->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('nisn', 'like', "%{$keyword}%");

            });

        }

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        if ($request->filled('scanner')) {

            $query->where('scanner_id', $request->scanner);

        }

        if ($request->filled('scan_by')) {

            $query->where('scan_by', $request->scan_by);

        }

        if ($request->filled('guru')) {

            $query->where('guru_id', $request->guru);

        }

        if ($request->filled('metode')) {

            $query->where('metode', $request->metode);

        }

        $presensis = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('presensi.index', compact(

            'presensis',

            'gurus',

            'scanner'

        ));
    }

    /**
     * Halaman Scan
     */
    public function create()
    {
        $tahunAjaran = TahunAjaran::where('aktif', true)->first();

        $pengaturan = Pengaturan::first();

        $riwayat = Presensi::with([
               'siswa.kelas',
               'scanner'
            ])
            ->whereDate('tanggal', today())
            ->latest('jam_scan')
            ->get();

        return view('presensi.create', compact(
            'tahunAjaran',
            'pengaturan',
            'riwayat'
        ));
    }

    /**
     * Simpan Manual
     */
    public function store(Request $request)
    {
        $request->validate([

            'siswa_id' => 'required|exists:siswas,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'tanggal' => 'required|date',
            'jam_scan' => 'required',
            'status' => 'required',
            'metode' => 'required',
            'keterangan' => 'nullable',
            'device_name' => 'nullable',

        ]);

        $user = auth()->user();

        $presensi = Presensi::create([

            'siswa_id'        => $request->siswa_id,
            'guru_id'         => $request->guru_id,
            'scanner_id'      => $user->id,
            'scan_by'         => $user->role,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tanggal'         => $request->tanggal,
            'jam_scan'        => $request->jam_scan,
            'status'          => $request->status,
            'metode'          => $request->metode,
            'keterangan'      => $request->keterangan,
            'device_name'     => $request->device_name,

        ]);

        ActivityHelper::log(
            'Tambah Presensi',
            'Presensi',
            'Menambahkan presensi siswa: '.$presensi->siswa->nama
        );

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
        ->where(function ($q) use ($barcode) {
            $q->where('barcode', $barcode)
              ->orWhere('nisn', $barcode);
        })
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

    $pengaturan = Pengaturan::first();

    if (!$pengaturan) {
        return response()->json([
            'success' => false,
            'message' => 'Pengaturan sekolah belum dibuat.'
        ]);
    }

    $jamSekarang = now($pengaturan->timezone);
    $jam = $jamSekarang->format('H:i:s');

    if (
        $jam < $pengaturan->scan_mulai ||
        $jam > $pengaturan->scan_selesai
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Presensi di luar jam yang diizinkan.'
        ]);
    }

    $presensiHariIni = Presensi::where('siswa_id', $siswa->id)
        ->whereDate('tanggal', $jamSekarang->toDateString())
        ->exists();

    if ($presensiHariIni) {
        return response()->json([
            'success' => false,
            'message' => $siswa->nama.' sudah melakukan presensi hari ini.'
        ]);
    }

    $status = $jam <= $pengaturan->batas_terlambat
        ? 'Hadir'
        : 'Terlambat';

    $user = auth()->user();

    $guruId = null;

    if ($user->isGuru() && $user->guru) {
        $guruId = $user->guru->id;
    }

    $presensi = Presensi::create([

        'siswa_id'        => $siswa->id,
        'guru_id'         => $guruId,
        'scanner_id'      => $user->id,
        'scan_by'         => $user->role,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tanggal'         => $jamSekarang->toDateString(),
        'jam_scan'        => $jam,
        'status'          => $status,
        'metode'          => 'Barcode',
        'keterangan'      => null,
        'device_name'     => $request->userAgent(),

    ]);

    ActivityHelper::log(
        'Scan Barcode',
        'Presensi',
        'Scan presensi siswa: '.$siswa->nama
    );

    return response()->json([

        'success' => true,
        'message' => 'Presensi berhasil.',

        'id' => $presensi->id,
        'nama' => $siswa->nama,
        'kelas' => optional($siswa->kelas)->nama_lengkap ?? '-',
        'status' => $status,
        'jam' => $presensi->jam_scan,
        'tanggal' => $presensi->tanggal,

        'foto' => $siswa->foto
            ? asset('storage/'.$siswa->foto)
            : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama).'&size=200',

        'scanner' => [
            'nama' => $user->nama,
            'role' => ucwords(str_replace('_',' ',$user->role)),
            'warna' => match ($user->role) {
                'admin' => 'danger',
                'guru' => 'success',
                'ketua_kelas' => 'primary',
                'sekretaris' => 'purple',
                default => 'secondary',
            },
        ],

    ]);
}

    /**
     * Detail
     */
    public function show(Presensi $presensi)
    {
        $presensi->load([
            'siswa.kelas',
            'guru',
            'scanner',
            'tahunAjaran'
        ]);

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
     * Update
     */
    public function update(Request $request, Presensi $presensi)
    {
        $request->validate([

            'siswa_id' => 'required|exists:siswas,id',
            'guru_id' => 'nullable|exists:gurus,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'tanggal' => 'required|date',
            'jam_scan' => 'required',
            'status' => 'required',
            'metode' => 'required',
            'keterangan' => 'nullable',
            'device_name' => 'nullable',

        ]);

        $presensi->update([

            'siswa_id'        => $request->siswa_id,
            'guru_id'         => $request->guru_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tanggal'         => $request->tanggal,
            'jam_scan'        => $request->jam_scan,
            'status'          => $request->status,
            'metode'          => $request->metode,
            'keterangan'      => $request->keterangan,
            'device_name'     => $request->device_name,

        ]);

        $presensi->load('siswa');

        ActivityHelper::log(
            'Edit Presensi',
            'Presensi',
            'Mengubah presensi siswa: '.$presensi->siswa->nama
        );

        return redirect()
            ->route('presensi.index')
            ->with('success', 'Data presensi berhasil diperbarui.');
    }

    /**
     * Hapus
     */
    public function destroy(Presensi $presensi)
    {
        $namaSiswa = optional($presensi->siswa)->nama ?? '-';

        ActivityHelper::log(
            'Hapus Presensi',
            'Presensi',
            'Menghapus presensi siswa: '.$namaSiswa
        );

        $presensi->delete();

        return redirect()
            ->route('presensi.index')
            ->with('success', 'Data presensi berhasil dihapus.');
    }
}