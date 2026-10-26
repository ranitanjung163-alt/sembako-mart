<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user belum login sama sekali
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Ambil data user yang sedang login
        $user = $request->user();

        // 3. Cek apakah role user ada di dalam daftar yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 4. Jika role tidak sesuai / tidak punya hak akses, kembalikan ke dashboard dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Akses ditolak! Berdasarkan aturan sistem, Anda tidak memiliki izin ke halaman ini.');
    }
}