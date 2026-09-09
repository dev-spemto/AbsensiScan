<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PengurusKelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ActivityHelper;
use Illuminate\Support\Facades\DB;

class PengurusKelasController extends Controller
{
    /**
     * Daftar Pengurus Kelas
     */
    public function index()
    {
        $pengurus = PengurusKelas::with([
            'kelas',
            'ketua',
            'wakil',
            'sekretaris',
            'ketuaUser',
            'wakilUser',
            'sekretarisUser',
        ])
        ->orderBy('kelas_id')
        ->get();

        return view('pengurus-kelas.index', compact('pengurus'));
    }

    /**
     * Form Edit
     */
    public function edit(PengurusKelas $pengurus_kela)
    {
        return view('pengurus-kelas.edit', [

            'pengurus' => $pengurus_kela,

            'kelas' => Kelas::orderBy('tingkat')
                ->orderBy('nama_kelas')
                ->get(),

            'siswas' => Siswa::where('kelas_id', $pengurus_kela->kelas_id)
                ->orderBy('nama')
                ->get(),

        ]);
    }

    /**
     * Simpan Pengurus Kelas
     */
    public function update(Request $request, PengurusKelas $pengurus_kela)
    {
        $request->validate([
            'ketua_siswa_id' => [
                'nullable',
                'exists:siswas,id',
                'distinct',
            ],

            'wakil_siswa_id' => [
                'nullable',
                'exists:siswas,id',
                'distinct',
            ],

            'sekretaris_siswa_id' => [
                'nullable',
                'exists:siswas,id',
                'distinct',
            ],
        ]);

        DB::transaction(function () use ($request, $pengurus_kela) {

            /*
            |--------------------------------------------------------------------------
            | Simpan ID pengurus lama
            |--------------------------------------------------------------------------
            */

            $pengurusLama = array_filter([
                $pengurus_kela->ketua_siswa_id,
                $pengurus_kela->wakil_siswa_id,
                $pengurus_kela->sekretaris_siswa_id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Hapus akun login pengurus lama
            |--------------------------------------------------------------------------
            */

            foreach ([
                $pengurus_kela->ketuaUser,
                $pengurus_kela->wakilUser,
                $pengurus_kela->sekretarisUser,
            ] as $user) {

                if ($user) {
                    $user->delete();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Reset jabatan siswa lama
            |--------------------------------------------------------------------------
            |
            | Penting:
            | Pengurus lama tidak boleh tetap memiliki jabatan di tabel siswas.
            |
            */

            if (!empty($pengurusLama)) {

                Siswa::whereIn('id', $pengurusLama)
                    ->update([
                        'jabatan' => null,
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Format nama kelas
            |--------------------------------------------------------------------------
            */

            $kelas = strtolower(
                $pengurus_kela->kelas->tingkat .
                $pengurus_kela->kelas->nama_kelas
            );

            /*
            |--------------------------------------------------------------------------
            | Ketua Kelas
            |--------------------------------------------------------------------------
            */

            $ketuaUser = null;

            if ($request->filled('ketua_siswa_id')) {

                $ketua = Siswa::findOrFail(
                    $request->ketua_siswa_id
                );

                /*
                | Isi jabatan siswa
                */

                $ketua->update([
                    'jabatan' => 'Ketua Kelas',
                ]);

                /*
                | Buat akun ketua
                */

                $ketuaUser = User::updateOrCreate(

                    [
                        'username' => "spemto@$kelas",
                    ],

                    [
                        'nama' => $ketua->nama,
                        'password' => Hash::make("ketua@$kelas"),
                        'role' => 'ketua_kelas',
                        'aktif' => true,
                        'siswa_id' => $ketua->id,
                    ]

                );
            }

            /*
            |--------------------------------------------------------------------------
            | Wakil Kelas
            |--------------------------------------------------------------------------
            */

            $wakilUser = null;

            if ($request->filled('wakil_siswa_id')) {

                $wakil = Siswa::findOrFail(
                    $request->wakil_siswa_id
                );

                /*
                | Isi jabatan siswa
                */

                $wakil->update([
                    'jabatan' => 'Wakil Kelas',
                ]);

                /*
                | Buat akun wakil
                */

                $wakilUser = User::updateOrCreate(

                    [
                        'username' => "wakil@$kelas",
                    ],

                    [
                        'nama' => $wakil->nama,
                        'password' => Hash::make("wakil@$kelas"),
                        'role' => 'wakil_kelas',
                        'aktif' => true,
                        'siswa_id' => $wakil->id,
                    ]

                );
            }

            /*
            |--------------------------------------------------------------------------
            | Sekretaris
            |--------------------------------------------------------------------------
            */

            $sekretarisUser = null;

            if ($request->filled('sekretaris_siswa_id')) {

                $sekretaris = Siswa::findOrFail(
                    $request->sekretaris_siswa_id
                );

                /*
                | Isi jabatan siswa
                */

                $sekretaris->update([
                    'jabatan' => 'Sekretaris',
                ]);

                /*
                | Buat akun sekretaris
                */

                $sekretarisUser = User::updateOrCreate(

                    [
                        'username' => "sekretaris@$kelas",
                    ],

                    [
                        'nama' => $sekretaris->nama,
                        'password' => Hash::make("sekretaris@$kelas"),
                        'role' => 'sekretaris',
                        'aktif' => true,
                        'siswa_id' => $sekretaris->id,
                    ]

                );
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan relasi Pengurus Kelas
            |--------------------------------------------------------------------------
            */

            $pengurus_kela->update([

                'ketua_siswa_id' => $request->ketua_siswa_id,
                'ketua_user_id' => $ketuaUser?->id,

                'wakil_siswa_id' => $request->wakil_siswa_id,
                'wakil_user_id' => $wakilUser?->id,

                'sekretaris_siswa_id' => $request->sekretaris_siswa_id,
                'sekretaris_user_id' => $sekretarisUser?->id,

            ]);

            /*
            |--------------------------------------------------------------------------
            | Activity Log
            |--------------------------------------------------------------------------
            */

            ActivityHelper::log(
                'Edit Data',
                'Pengurus Kelas',
                'Mengubah pengurus kelas ' .
                $pengurus_kela->kelas->nama_lengkap
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('pengurus-kelas.index')
            ->with(
                'success',
                'Pengurus kelas berhasil diperbarui.'
            );
    }

    /**
     * Reset Password Pengurus Kelas
     */
    public function resetPassword(PengurusKelas $pengurus_kela)
    {
        $kelas = strtolower(
            $pengurus_kela->kelas->tingkat .
            $pengurus_kela->kelas->nama_kelas
        );

        if ($pengurus_kela->ketuaUser) {

            $pengurus_kela->ketuaUser->update([
                'password' => Hash::make("ketua@$kelas"),
            ]);

        }

        if ($pengurus_kela->wakilUser) {

            $pengurus_kela->wakilUser->update([
                'password' => Hash::make("wakil@$kelas"),
            ]);

        }

        if ($pengurus_kela->sekretarisUser) {

            $pengurus_kela->sekretarisUser->update([
                'password' => Hash::make("sekretaris@$kelas"),
            ]);

        }
        
        ActivityHelper::log(
            'Reset Password',
            'Pengurus Kelas',
            'Reset password pengurus kelas '.$pengurus_kela->kelas->nama_kelas
        );

        return redirect()
            ->route('pengurus-kelas.index')
            ->with('success', 'Password seluruh pengurus kelas berhasil direset.');
    }

    /**
     * Form Ubah Password
     */
    public function editPassword(PengurusKelas $pengurus_kela)
    {
        return view('pengurus-kelas.password', [

            'pengurus' => $pengurus_kela,

        ]);
    }

    /**
     * Simpan Password Baru
     */
    public function updatePassword(Request $request, PengurusKelas $pengurus_kela)
    {
        $request->validate([

            'ketua_password'      => 'nullable|string|min:6|max:255',
            'wakil_password'      => 'nullable|string|min:6|max:255',
            'sekretaris_password' => 'nullable|string|min:6|max:255',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Ketua
        |--------------------------------------------------------------------------
        */

        if (
            $pengurus_kela->ketuaUser &&
            $request->filled('ketua_password')
        ) {

            $pengurus_kela->ketuaUser->update([

                'password' => Hash::make($request->ketua_password),

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Wakil
        |--------------------------------------------------------------------------
        */

        if (
            $pengurus_kela->wakilUser &&
            $request->filled('wakil_password')
        ) {

            $pengurus_kela->wakilUser->update([

                'password' => Hash::make($request->wakil_password),

            ]);

        }

        /*
        |--------------------------------------------------------------------------
        | Sekretaris
        |--------------------------------------------------------------------------
        */

        if (
            $pengurus_kela->sekretarisUser &&
            $request->filled('sekretaris_password')
        ) {

            $pengurus_kela->sekretarisUser->update([

                'password' => Hash::make($request->sekretaris_password),

            ]);

        }

        ActivityHelper::log(
            'Ubah Password',
            'Pengurus Kelas',
            'Mengubah password pengurus kelas '.$pengurus_kela->kelas->nama_kelas
        );
        
        return redirect()
            ->route('pengurus-kelas.index')
            ->with(
                'success',
                'Password pengurus kelas berhasil diperbarui.'
            );
    }
}