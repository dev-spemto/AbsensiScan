<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {

            return redirect()->route('login');

        }

        if (
            !method_exists(auth()->user(), 'isAdmin') ||
            !auth()->user()->isAdmin()
        ) {

            abort(403, 'Anda tidak memiliki hak akses.');

        }

        return $next($request);
    }
}