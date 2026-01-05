<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (!auth()->check()) {
            // auth()->check() = return true jika sudah login, false jika belum
            // !auth()->check() = NOT login = belum login

            return redirect()->route('login');
            // ↑ Redirect ke halaman login
        }

        // ================================================
        // STEP 2: Cek apakah user adalah admin
        // ================================================
        if (auth()->user()->role !== 'admin') {
            // auth()->user()        = Ambil data user yang login
            // auth()->user()->role  = Ambil nilai kolom 'role'
            // !== 'admin'           = Bukan admin

            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            // ↑ abort(403) = Tampilkan halaman error 403 (Forbidden)
            // Artinya: "Kamu dilarang masuk ke sini!"
        }

        // ================================================
        // STEP 3: Jika lolos semua pengecekan, lanjutkan request
        // ================================================
        return $next($request);
        // ↑ $next($request) = Lanjutkan ke controller tujuan
    }
}
