<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Daftar Guru
     */
    public function index()
    {
        $gurus = Guru::orderBy('nama')->paginate(10);

        return view('guru.index', compact('gurus'));
    }

    /**
     * Form Tambah Guru
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Simpan Guru
     */
    public function store(Request $request)
    {
        $request->validate([

            'nip' => 'required|max:30|unique:gurus,nip',

            'nama' => 'required|max:100',

            'tempat_lahir' => 'nullable|max:100',

            'tanggal_lahir' => 'nullable|date',

            'jenis_kelamin' => 'nullable|in:L,P',

            'no_hp' => 'nullable|max:20',

            'email' => 'nullable|email',

            'alamat' => 'nullable',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'username' => 'required|max:50|unique:gurus,username',

            'password' => 'required|min:6',

            'aktif' => 'required|boolean',

        ]);

        $foto = null;

        if ($request->hasFile('foto')) {

            $foto = $request->file('foto')->store('guru', 'public');

        }

        $guru = Guru::create([

            'nip' => $request->nip,

            'nama' => $request->nama,

            'tempat_lahir' => $request->tempat_lahir,

            'tanggal_lahir' => $request->tanggal_lahir,

            'jenis_kelamin' => $request->jenis_kelamin,

            'no_hp' => $request->no_hp,

            'email' => $request->email,

            'alamat' => $request->alamat,

            'foto' => $foto,

            'username' => $request->username,

            'password' => Hash::make($request->password),

            'aktif' => $request->aktif,

        ]);

        User::updateOrCreate(

            [

                'username' => $guru->username,

            ],

            [

                'nama' => $guru->nama,

                'password' => $guru->password,

                'role' => 'guru',

                'aktif' => $guru->aktif,

            ]

        );

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Detail Guru
     */
    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    /**
     * Form Edit Guru
     */
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update Guru
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([

            'nip' => [

                'required',

                Rule::unique('gurus')->ignore($guru->id),

            ],

            'username' => [

                'required',

                Rule::unique('gurus')->ignore($guru->id),

            ],

            'nama' => 'required|max:100',

            'tempat_lahir' => 'nullable|max:100',

            'tanggal_lahir' => 'nullable|date',

            'jenis_kelamin' => 'nullable|in:L,P',

            'no_hp' => 'nullable|max:20',

            'email' => 'nullable|email',

            'alamat' => 'nullable',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'aktif' => 'required|boolean',

        ]);

        $foto = $guru->foto;

        if ($request->hasFile('foto')) {

            if ($foto && Storage::disk('public')->exists($foto)) {

                Storage::disk('public')->delete($foto);

            }

            $foto = $request->file('foto')->store('guru', 'public');

        }

        $data = [

            'nip' => $request->nip,

            'nama' => $request->nama,

            'tempat_lahir' => $request->tempat_lahir,

            'tanggal_lahir' => $request->tanggal_lahir,

            'jenis_kelamin' => $request->jenis_kelamin,

            'no_hp' => $request->no_hp,

            'email' => $request->email,

            'alamat' => $request->alamat,

            'foto' => $foto,

            'username' => $request->username,

            'aktif' => $request->aktif,

        ];

        if ($request->filled('password')) {

            $data['password'] = Hash::make($request->password);

        }

        $guru->update($data);

        User::updateOrCreate(

            [

                'username' => $guru->username,

            ],

            [

                'nama' => $guru->nama,

                'password' => $guru->password,

                'role' => 'guru',

                'aktif' => $guru->aktif,

            ]

        );

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Hapus Guru
     */
    public function destroy(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {

            Storage::disk('public')->delete($guru->foto);

        }

        User::where('username', $guru->username)->delete();

        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}