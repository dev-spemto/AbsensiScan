<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PengaturanController extends Controller
{
    /**
     * Form Pengaturan
     */
    public function index()
    {
        $pengaturan = Pengaturan::first();

        return view('pengaturan.index', compact('pengaturan'));
    }

    /**
     * Simpan Pengaturan
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'      => 'required|max:100',
            'alamat_sekolah'    => 'nullable|max:255',
            'telepon'           => 'nullable|max:30',
            'email'             => 'nullable|email',
            'kepala_sekolah'    => 'nullable|max:100',
            'jam_masuk'         => 'required',
            'batas_terlambat'   => 'required',
            'scan_mulai'        => 'required',
            'scan_selesai'      => 'required',
            'timezone'          => 'required',
            'aktifkan_foto'     => 'boolean',
            'aktifkan_suara'    => 'boolean',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $pengaturan = Pengaturan::first();

            if (!$pengaturan) {
                $pengaturan = Pengaturan::create([]);
            }

            $logo = $pengaturan->logo;

            if ($request->hasFile('logo')) {

                $logoBaru = $request->file('logo')
                    ->store('logo', 'public');

                if (
                    $logo &&
                    Storage::disk('public')->exists($logo)
                ) {
                    Storage::disk('public')->delete($logo);
                }

                $logo = $logoBaru;
            }

            $pengaturan->update([

                'nama_sekolah'      => $request->nama_sekolah,
                'alamat_sekolah'    => $request->alamat_sekolah,
                'telepon'           => $request->telepon,
                'email'             => $request->email,
                'kepala_sekolah'    => $request->kepala_sekolah,
                'jam_masuk'         => $request->jam_masuk,
                'batas_terlambat'   => $request->batas_terlambat,
                'scan_mulai'        => $request->scan_mulai,
                'scan_selesai'      => $request->scan_selesai,
                'timezone'          => $request->timezone,
                'aktifkan_foto'     => $request->boolean('aktifkan_foto'),
                'aktifkan_suara'    => $request->boolean('aktifkan_suara'),
                'logo'              => $logo,

            ]);

            ActivityHelper::log(
                'Edit Pengaturan',
                'Pengaturan',
                'Mengubah pengaturan aplikasi'
            );

            DB::commit();

            return back()->with(
                'success',
                'Pengaturan berhasil disimpan.'
            );

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menyimpan pengaturan.'
                );
        }
    }
}