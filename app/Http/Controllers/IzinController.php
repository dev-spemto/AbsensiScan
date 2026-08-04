<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Throwable;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $izins = Izin::with('siswa')
            ->latest()
            ->paginate(10);

        return view('izin.index', compact('izins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::where('aktif', true)
            ->orderBy('nama')
            ->get();

        return view('izin.create', compact('siswas'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([

            'siswa_id'   => 'required|exists:siswas,id',
            'tanggal'    => 'required|date',
            'jenis'      => 'required|in:Izin,Sakit',
            'keterangan' => 'nullable|string',
            'bukti'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',

        ]);

        $path = $request->file('bukti')
            ->store('izin', 'public');

        Izin::create([

            'siswa_id'       => $request->siswa_id,
            'tanggal'        => $request->tanggal,
            'jenis'          => $request->jenis,
            'keterangan'     => $request->keterangan,
            'bukti'          => $path,
            'status'         => 'Pending',
            'disetujui_oleh' => null,

        ]);

        return redirect()
            ->route('izin.index')
            ->with('success', 'Pengajuan izin berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Izin $izin)
    {
        $izin->load('siswa');

        return view('izin.show', compact('izin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Izin $izin)
    {
        $siswas = Siswa::where('aktif', true)
            ->orderBy('nama')
            ->get();

        return view('izin.edit', compact(
            'izin',
            'siswas'
        ));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Izin $izin)
    {
        $request->validate([

            'siswa_id'   => 'required|exists:siswas,id',
            'tanggal'    => 'required|date',
            'jenis'      => 'required|in:Izin,Sakit',
            'keterangan' => 'nullable|string',
            'status'     => 'required|in:Pending,Disetujui,Ditolak',

        ]);

        DB::beginTransaction();

        try {

            $izin->update([

                'siswa_id'       => $request->siswa_id,
                'tanggal'        => $request->tanggal,
                'jenis'          => $request->jenis,
                'keterangan'     => $request->keterangan,
                'status'         => $request->status,
                'disetujui_oleh' => auth()->id(),

            ]);

            if ($request->status === 'Disetujui') {

                $tahunAjaran = TahunAjaran::where('aktif', true)->first();

                if (!$tahunAjaran) {

                    throw new \Exception('Tahun ajaran aktif belum tersedia.');

                }

                Presensi::firstOrCreate(

                    [
                        'siswa_id' => $izin->siswa_id,
                        'tanggal'  => $izin->tanggal,
                    ],

                    [
                        'guru_id'         => 1,
                        'scanner_id'      => auth()->id(),
                        'scan_by'         => auth()->user()->role,
                        'tahun_ajaran_id' => $tahunAjaran->id,
                        'jam_scan'        => '07:00:00',
                        'status'          => $izin->jenis,
                        'metode'          => 'Manual',
                        'keterangan'      => $izin->keterangan,
                        'device_name'     => 'Approval Izin',
                    ]

                );

            }

            DB::commit();

            return redirect()
                ->route('izin.index')
                ->with('success', 'Data izin berhasil diperbarui.');

        } catch (Throwable $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());

        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Izin $izin)
    {
        $izin->delete();

        return redirect()
            ->route('izin.index')
            ->with('success', 'Data izin berhasil dihapus.');
    }
}