<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Periksa role_id pengguna
        $user = Auth::user();
        if ($user->role_id != $role) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki izin mengakses halaman ini.');
        }

        return $next($request);
    }
}
