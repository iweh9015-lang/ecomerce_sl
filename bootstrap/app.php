<?php

// ========================================
// FILE: bootstrap/app.php
// FUNGSI: Konfigurasi utama aplikasi Laravel
// ========================================

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ================================================
        // DAFTARKAN MIDDLEWARE ALIAS
        // ================================================
        // Alias adalah "nama pendek" untuk middleware
        // Setelah didaftarkan, bisa dipakai dengan nama 'admin'
        // ================================================
        $middleware->alias([
            'admin' => App\Http\Middleware\AdminMiddleware::class,
            // ↑ 'admin' adalah nama alias
            // ↑ AdminMiddleware::class adalah class yang dijalankan
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
