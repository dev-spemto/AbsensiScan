<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ActivityHelper;

class AuthController extends Controller
{
    /**
     * Halaman Login
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->aktif) {

                Auth::logout();

                return back()->with('error', 'Akun tidak aktif.');
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Login Berhasil
            |--------------------------------------------------------------------------
            */

            LoginLog::create([
                'user_id'    => $user->id,
                'nama'       => $user->nama,
                'username'   => $user->username,
                'role'       => $user->role,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status'     => 'berhasil',
                'login_at'   => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Redirect Berdasarkan Role
            |--------------------------------------------------------------------------
            */

            if ($user->isAdmin()) {
                return redirect()->route('dashboard');
            }

            if ($user->isGuru()) {
                return redirect()->route('presensi.create');
            }

            if (
                $user->isKetuaKelas() ||
                $user->isWakilKelas() ||
                $user->isSekretaris()
            ) {
                return redirect()->route('presensi.create');
            }

            Auth::logout();

            return back()->with('error', 'Role akun tidak dikenali.');
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Login Gagal
        |--------------------------------------------------------------------------
        */

        LoginLog::create([
            'user_id'    => null,
            'nama'       => '-',
            'username'   => $request->username,
            'role'       => '-',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status'     => 'gagal',
            'login_at'   => now(),
        ]);

        return back()
            ->withInput()
            ->with('error', 'Username atau Password salah.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if (auth()->check()) {

            ActivityHelper::log(
                'Logout',
                'Autentikasi',
                'Logout dari sistem'
            );
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Profil
     */
    public function profil()
    {
        return view('auth.profil');
    }

    /**
     * Form Ubah Password
     * Hanya Administrator yang diperbolehkan.
     */
    public function editPassword()
    {
        if (!auth()->user()->isAdmin()) {
            abort(404);
        }

        return view('auth.password');
    }

    /**
     * Simpan Password Baru
     * Hanya Administrator yang diperbolehkan.
     */
    public function updatePassword(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(404);
        }

        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {

            return back()->withErrors([
                'password_lama' => 'Password lama tidak sesuai.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityHelper::log(
            'Ubah Password',
            'Profil',
            'Mengubah password akun'
        );

        return redirect()
            ->route('profil')
            ->with('success', 'Password berhasil diubah.');
    }
}