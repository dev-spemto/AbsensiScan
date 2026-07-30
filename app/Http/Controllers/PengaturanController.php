<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $pengaturan = Pengaturan::first();

        if (!$pengaturan) {
            $pengaturan = new Pengaturan();
        }

        $logo = $pengaturan->logo;

        if ($request->hasFile('logo')) {

            if ($logo && Storage::disk('public')->exists($logo)) {
                Storage::disk('public')->delete($logo);
            }

            $logo = $request->file('logo')->store('logo', 'public');
        }

        $pengaturan->updateOrCreate(
            ['id' => $pengaturan->id],
            [
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
            ]
        );

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}