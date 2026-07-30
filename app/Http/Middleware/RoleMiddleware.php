<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        /*
        |--------------------------------------------------------------------------
        | Belum Login
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {

            return redirect()->route('login');

        }

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Akun Tidak Aktif
        |--------------------------------------------------------------------------
        */

        if (!$user->aktif) {

            auth()->logout();

            return redirect()
                ->route('login')
                ->with('error', 'Akun Anda sudah dinonaktifkan.');

        }

        /*
        |--------------------------------------------------------------------------
        | Cek Hak Akses
        |--------------------------------------------------------------------------
        */

        if (!in_array($user->role, $roles)) {

            abort(403, 'Anda tidak memiliki hak akses.');

        }

        return $next($request);
    }
}