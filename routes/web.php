<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/sapa/{nama}', function ($nama) {
    return "Halo, $nama! Selamat datang di Toko Online Kami.";
});

Route::get('/kategori/{nama?}', function ($nama = 'Semua') {
    return "Menampilkan kategori: $nama";
});

Route::get('/produk/{id}', function ($id) {
    return "Detail produk $id";
})->name('produk.detail');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// ========================================
// FILE: routes/web.php
// FUNGSI: Mendefinisikan semua URL route aplikasi
// ========================================

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// ================================================
// ROUTE PUBLIK (Bisa diakses siapa saja)
// ================================================
Route::get('/', function () {
    return view('welcome');
});
// ↑ Halaman utama, tidak perlu login

// ================================================
// AUTH ROUTES
// ================================================
// Auth::routes() adalah "shortcut" yang membuat banyak route sekaligus:
// - GET  /login           → Tampilkan form login
// - POST /login           → Proses login
// - POST /logout          → Proses logout
// - GET  /register        → Tampilkan form register
// - POST /register        → Proses register
// - GET  /password/reset  → Tampilkan form lupa password
// - POST /password/email  → Kirim email reset password
// - dll...
// ================================================
Auth::routes();

// ================================================
// ROUTE YANG MEMERLUKAN LOGIN
// ================================================
// middleware('auth') = Harus login dulu untuk akses
// Jika belum login, otomatis redirect ke /login
// ================================================
Route::middleware('auth')->group(function () {
    // Semua route di dalam group ini HARUS LOGIN

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    // ↑ ->name('home') = Memberi nama route
    // Kegunaan: route('home') akan menghasilkan URL /home

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    // login
    Route::middleware(['auth', 'admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // /admin/dashboard
            Route::get('/dashboard', [AdminController::class, 'dashboard'])
                ->name('dashboard');
            // ↑ Nama lengkap route: admin.dashboard
            // ↑ URL: /admin/dashboard

            // CRUD Produk: /admin/products, /admin/products/create, dll
            Route::resource('/products', AdminProductController::class);
        });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
use App\Http\Controllers\Auth\GoogleController;

// ================================================
// GOOGLE OAUTH ROUTES
// ================================================
// Route ini diakses oleh browser, tidak perlu middleware auth
// ================================================

Route::controller(GoogleController::class)->group(function () {
    // ================================================
    // ROUTE 1: REDIRECT KE GOOGLE
    // ================================================
    // URL: /auth/google
    // Dipanggil saat user klik tombol "Login dengan Google"
    // ================================================
    Route::get('/auth/google', 'redirect')
        ->name('auth.google');

    // ================================================
    // ROUTE 2: CALLBACK DARI GOOGLE
    // ================================================
    // URL: /auth/google/callback
    // Dipanggil oleh Google setelah user klik "Allow"
    // URL ini HARUS sama dengan yang didaftarkan di Google Console!
    // ================================================
    Route::get('/auth/google/callback', 'callback')
        ->name('auth.google.callback');
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
