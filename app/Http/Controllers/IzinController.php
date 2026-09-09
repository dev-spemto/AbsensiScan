<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityHelper;
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

        DB::beginTransaction();

        try {

            $path = $request->file('bukti')
                ->store('izin', 'public');

            $izin = Izin::create([

                'siswa_id'       => $request->siswa_id,
                'tanggal'        => $request->tanggal,
                'jenis'          => $request->jenis,
                'keterangan'     => $request->keterangan,
                'bukti'          => $path,
                'status'         => 'Pending',
                'disetujui_oleh' => null,

            ]);

            DB::commit();

            ActivityHelper::log(
                'Tambah Data',
                'Izin',
                'Menambahkan izin siswa: '.$izin->siswa->nama
            );

            return redirect()
                ->route('izin.index')
                ->with('success', 'Pengajuan izin berhasil disimpan.');

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menyimpan izin.'
                );

        }
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
            'bukti'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',

        ]);

        DB::beginTransaction();

        try {

            $bukti = $izin->bukti;

            if ($request->hasFile('bukti')) {

                if (
                    $bukti &&
                    Storage::disk('public')->exists($bukti)
                ) {
                    Storage::disk('public')->delete($bukti);
                }

                $bukti = $request->file('bukti')
                    ->store('izin', 'public');
            }

            $izin->update([

                'siswa_id'       => $request->siswa_id,
                'tanggal'        => $request->tanggal,
                'jenis'          => $request->jenis,
                'keterangan'     => $request->keterangan,
                'status'         => $request->status,
                'bukti'          => $bukti,
                'disetujui_oleh' => auth()->id(),

            ]);

            $tahunAjaran = TahunAjaran::where('aktif', true)->first();

            if (
                $request->status === 'Disetujui' &&
                $tahunAjaran
            ) {

                Presensi::updateOrCreate(

                    [
                        'siswa_id' => $izin->siswa_id,
                        'tanggal'  => $izin->tanggal,
                    ],

                    [
                        'guru_id'         => auth()->user()->guru->id ?? null,
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

            } else {

                Presensi::where('siswa_id', $izin->siswa_id)
                    ->whereDate('tanggal', $izin->tanggal)
                    ->whereIn('status', ['Izin', 'Sakit'])
                    ->delete();

            }

            DB::commit();

            ActivityHelper::log(
                'Edit Data',
                'Izin',
                'Mengubah izin siswa: '.$izin->siswa->nama
            );

            return redirect()
                ->route('izin.index')
                ->with('success', 'Data izin berhasil diperbarui.');

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat memperbarui izin.'
                );

        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Izin $izin)
    {
        DB::beginTransaction();

        try {

            $nama = optional($izin->siswa)->nama ?? '-';

            Presensi::where('siswa_id', $izin->siswa_id)
                ->whereDate('tanggal', $izin->tanggal)
                ->whereIn('status', ['Izin', 'Sakit'])
                ->delete();

            if (
                $izin->bukti &&
                Storage::disk('public')->exists($izin->bukti)
            ) {
                Storage::disk('public')->delete($izin->bukti);
            }

            $izin->delete();

            DB::commit();

            ActivityHelper::log(
                'Hapus Data',
                'Izin',
                'Menghapus izin siswa: '.$nama
            );

            return redirect()
                ->route('izin.index')
                ->with('success', 'Data izin berhasil dihapus.');

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat menghapus data.'
            );

        }
    }
}