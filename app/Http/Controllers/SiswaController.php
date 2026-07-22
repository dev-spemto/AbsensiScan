<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa.
     */
    public function index()
    {
        $siswas = Siswa::with('kelas')
            ->orderBy('nama')
            ->paginate(10);

        return view('siswa.index', compact('siswas'));
    }

    /**
     * Form tambah siswa.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('siswa.create', compact('kelas'));
    }

    /**
     * Simpan siswa baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis'             => 'required|max:20|unique:siswas,nis',
            'nisn'            => 'required|max:20|unique:siswas,nisn',
            'nama'            => 'required|max:100',
            'tempat_lahir'    => 'required|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:L,P',
            'alamat'          => 'required',
            'kelas_id'        => 'required|exists:kelas,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aktif'           => 'required|boolean',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('siswa', 'public');
        }

        Siswa::create([
            'nis'             => $request->nis,
            'nisn'            => $request->nisn,
            'barcode'         => $request->nisn,
            'nama'            => $request->nama,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'alamat'          => $request->alamat,
            'kelas_id'        => $request->kelas_id,
            'foto'            => $foto,
            'aktif'           => $request->aktif,
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Detail siswa.
     */
    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Form edit siswa.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => [
                'required',
                'max:20',
                Rule::unique('siswas')->ignore($siswa->id),
            ],

            'nisn' => [
                'required',
                'max:20',
                Rule::unique('siswas')->ignore($siswa->id),
            ],

            'nama'            => 'required|max:100',
            'tempat_lahir'    => 'required|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|in:L,P',
            'alamat'          => 'required',
            'kelas_id'        => 'required|exists:kelas,id',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'aktif'           => 'required|boolean',
        ]);

        $foto = $siswa->foto;

        if ($request->hasFile('foto')) {

            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $foto = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update([
            'nis'             => $request->nis,
            'nisn'            => $request->nisn,
            'barcode'         => $request->nisn,
            'nama'            => $request->nama,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'alamat'          => $request->alamat,
            'kelas_id'        => $request->kelas_id,
            'foto'            => $foto,
            'aktif'           => $request->aktif,
        ]);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus siswa.
     */
    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}