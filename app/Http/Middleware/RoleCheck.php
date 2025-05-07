<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Pastikan user terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil user yang terautentikasi (dengan null check)
        $user = Auth::user();
        if (!$user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sesi tidak valid.');
        }

        // 3. Pastikan role user valid
        if (!isset($user->role)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak terdefinisi.');
        }

        // 4. Bandingkan role
        if ($user->role !== $role) {
            abort(403, 'Akses ditolak: Role tidak sesuai.');
        }

        return $next($request);
    }
}