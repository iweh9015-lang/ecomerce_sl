<?php

// ========================================
// FILE: app/Http/Middleware/AdminMiddleware.php
// FUNGSI: Membatasi akses hanya untuk user dengan role 'admin'
// ========================================

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Method ini dipanggil SETIAP KALI ada request yang melewati middleware ini.
     *
     * @param Request  $request Request dari user
     * @param \Closure $next    Fungsi untuk melanjutkan ke proses berikutnya
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // ================================================
        // STEP 1: Cek apakah user sudah login
        // ================================================
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
