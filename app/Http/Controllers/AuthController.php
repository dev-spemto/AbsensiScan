<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityHelper;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

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
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {

            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $request->boolean('remember'))) {

                $request->session()->regenerate();

                $user = Auth::user();

                if (!$user->aktif) {

                    Auth::logout();

                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->with(
                        'error',
                        'Akun tidak aktif.'
                    );

                }

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

                if ($user->isAdmin()) {
                    return redirect()->route('dashboard');
                }

                if (
                    $user->isGuru() ||
                    $user->isKetuaKelas() ||
                    $user->isWakilKelas() ||
                    $user->isSekretaris()
                ) {
                    return redirect()->route('presensi.create');
                }

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->with(
                    'error',
                    'Role akun tidak dikenali.'
                );
            }

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
                ->withInput($request->except('password'))
                ->with(
                    'error',
                    'Username atau Password salah.'
                );

        } catch (Throwable $e) {

            report($e);

            return back()->with(
                'error',
                'Terjadi kesalahan saat login.'
            );

        }
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
     */
    public function editPassword()
    {
        abort_unless(auth()->user()->isAdmin(), 404);

        return view('auth.password');
    }

    /**
     * Simpan Password Baru
     */
    public function updatePassword(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 404);

        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {

            return back()->withErrors([
                'password_lama' => 'Password lama tidak sesuai.',
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
            ->with(
                'success',
                'Password berhasil diubah.'
            );
    }
}