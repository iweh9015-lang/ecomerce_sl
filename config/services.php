<?php

// ========================================
// FILE: config/services.php
// FUNGSI: Konfigurasi untuk layanan pihak ketiga
// ========================================

return [
    // ================================================
    // Konfigurasi yang sudah ada (mailgun, postmark, dll)
    // ================================================

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        // ...
    ],

    // ... konfigurasi lainnya ...

    // ================================================
    // KONFIGURASI GOOGLE OAUTH
    // ================================================
    // Socialite akan membaca konfigurasi dari sini
    // Nama key 'google' sesuai dengan nama driver
    // ================================================

    'google' => [
        // Client ID dari Google Cloud Console
        'client_id' => env('GOOGLE_CLIENT_ID'),
        // ↑ env() membaca nilai dari file .env

        // Client Secret dari Google Cloud Console
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),

        // URL callback (harus didaftarkan di Google Console)
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
];
