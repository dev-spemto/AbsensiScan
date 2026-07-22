<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            return redirect()->route('dashboard');

        }

        return back()
            ->withInput()
            ->with('error', 'Username atau Password salah.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}