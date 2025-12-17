<?php

// ========================================
// FILE: app/Http/Controllers/Auth/GoogleController.php
// FUNGSI: Menghandle proses login dengan Google OAuth
// ========================================

namespace App\Http\Controllers\Auth;

// ↑ Namespace adalah "alamat" file dalam struktur folder
// File ini berada di app/Http/Controllers/Auth/

use App\Http\Controllers\Controller;  // Base controller
use App\Models\User;                   // Model User untuk interaksi database
use Illuminate\Support\Facades\Auth;   // Facade untuk authentication
use Illuminate\Support\Facades\Hash;   // Facade untuk hashing password
use Illuminate\Support\Str;             // Helper untuk string manipulation
use Laravel\Socialite\Facades\Socialite; // ⭐ Package Socialite untuk OAuth

// Class untuk handle error

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman OAuth Google.
     *
     * Method ini dipanggil ketika user klik tombol "Login dengan Google".
     * Socialite akan membangun URL lengkap dengan semua parameter OAuth.
     *
     * Route: GET /auth/google
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // ================================================
        // MEMBANGUN URL REDIRECT KE GOOGLE
        // ================================================
        // Socialite::driver('google') = Gunakan driver Google
        // scopes(['email', 'profile']) = Minta izin email dan profil
        // redirect() = Redirect browser ke URL Google OAuth
        // ================================================

        return Socialite::driver('google')
            // ->stateless() // Opsional: Gunakan jika error "InvalidStateException" terus muncul (bypass session state check)
            ->scopes(['email', 'profile'])
            // ↑ Scopes menentukan data apa yang kita minta
            // 'email'   = Alamat email user
            // 'profile' = Nama dan foto profil
            // 'openid'  = Otomatis ditambahkan untuk Google
            ->redirect();
        // ↑ Ini akan redirect ke URL seperti:
        // https://accounts.google.com/o/oauth2/v2/auth?
        //   client_id=xxx&
        //   redirect_uri=xxx&
        //   scope=email+profile&
        //   state=xxx&
        //   response_type=code
    }

    /**
     * Handle callback dari Google setelah user memberikan izin.
     *
     * Method ini dipanggil oleh Google setelah user klik "Allow".
     * Google akan mengirimkan authorization_code ke URL ini.
     *
     * Route: GET /auth/google/callback
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        // ================================================
        // CEK JIKA USER MEMBATALKAN LOGIN
        // ================================================
        // Jika user klik "Cancel" di halaman consent Google,
        // Google akan redirect dengan parameter 'error'
        // ================================================

        if (request()->has('error')) {
            $error = request('error');
            // ↑ request('error') mengambil nilai parameter ?error=xxx dari URL

            if ($error === 'access_denied') {
                return redirect()
                    ->route('login')
                    ->with('info', 'Login dengan Google dibatalkan.');
                // ↑ with('info', '...') = Flash message untuk ditampilkan sekali
            }

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan: '.$error);
        }

        // ================================================
        // PROSES OAUTH: TUKAR CODE DENGAN ACCESS TOKEN
        // ================================================

        try {
            // ================================================
            // LANGKAH PENTING!
            // ================================================
            // Socialite::driver('google')->user() melakukan:
            // 1. Ambil authorization_code dari URL parameter
            // 2. Kirim code + client_secret ke Google (server-to-server)
            // 3. Terima access_token dari Google
            // 4. Request data user menggunakan access_token
            // 5. Return object dengan data user
            // ================================================

            $googleUser = Socialite::driver('google')->user();
            // ↑ $googleUser berisi data user dari Google
            //   Contoh:
            //   - $googleUser->getId()     = "1234567890" (Google user ID)
            //   - $googleUser->getName()   = "John Doe"
            //   - $googleUser->getEmail()  = "john@gmail.com"
            //   - $googleUser->getAvatar() = "https://lh3.google.../photo.jpg"
            //   - $googleUser->token       = access_token (string panjang)

            // ================================================
            // CARI ATAU BUAT USER DI DATABASE
            // ================================================
            $user = $this->findOrCreateUser($googleUser);

            // ================================================
            // LOGIN USER KE APLIKASI
            // ================================================
            Auth::login($user, remember: true);
            // ↑ Auth::login()     = Login user ke sistem
            // ↑ remember: true    = Buat cookie "remember me" agar tidak
            //                       harus login lagi setelah browser ditutup

            // ================================================
            // REGENERATE SESSION (KEAMANAN!)
            // ================================================
            session()->regenerate();
            // ↑ Ganti session ID baru untuk mencegah "session fixation attack"
            // Ini adalah best practice keamanan

            // ================================================
            // REDIRECT KE HALAMAN TUJUAN
            // ================================================
            return redirect()
                ->intended(route('home'))
                // ↑ intended() = Redirect ke halaman yang coba diakses sebelumnya
                // Jika tidak ada, redirect ke 'home'
                ->with('success', 'Berhasil login dengan Google!');
            // ↑ Flash message sukses
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // ================================================
            // ERROR: STATE TIDAK VALID
            // ================================================
            // Ini terjadi jika:
            // - Session expired saat user di halaman Google
            // - Kemungkinan serangan CSRF
            // ================================================

            return redirect()
                ->route('login')
                ->with('error', 'Session telah berakhir. Silakan coba lagi.');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // ================================================
            // ERROR: MASALAH DENGAN GOOGLE API
            // ================================================
            // Contoh: credential tidak valid, quota exceeded, dll
            // ================================================

            logger()->error('Google API Error: '.$e->getMessage());
            // ↑ Log error untuk debugging (lihat di storage/logs/laravel.log)

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan saat menghubungi Google. Coba lagi.');
        } catch (\Exception $e) {
            // ================================================
            // ERROR: LAINNYA
            // ================================================

            logger()->error('OAuth Error: '.$e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Gagal login. Silakan coba lagi.');
        }
    }

    /**
     * Cari user berdasarkan Google ID atau email, atau buat user baru.
     *
     * Method ini menangani 3 skenario:
     * 1. User sudah pernah login dengan Google (ada google_id)
     * 2. User sudah register manual dengan email yang sama
     * 3. User benar-benar baru
     *
     * @param \Laravel\Socialite\Contracts\User $googleUser Data user dari Google
     *
     * @return User User dari database
     */
    protected function findOrCreateUser($googleUser): User
    {
        // ================================================
        // DATA YANG TERSEDIA DARI GOOGLE
        // ================================================
        // $googleUser->getId()        // Google user ID (unique, tidak berubah)
        // $googleUser->getName()      // Nama lengkap
        // $googleUser->getEmail()     // Email (dijamin verified oleh Google)
        // $googleUser->getAvatar()    // URL foto profil
        // $googleUser->token          // Access token
        // $googleUser->refreshToken   // Refresh token (null jika tidak diminta)
        // ================================================

        // ================================================
        // SKENARIO 1: USER SUDAH PERNAH LOGIN DENGAN GOOGLE
        // ================================================
        // Cari user yang punya google_id yang sama
        // ================================================

        $user = User::where('google_id', $googleUser->getId())->first();
        // ↑ Cari di tabel users WHERE google_id = '...'

        if ($user) {
            // User ditemukan! Cek apakah avatar berubah
            if ($user->avatar !== $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
                // ↑ Update avatar jika user ganti foto profil di Google
            }

            return $user;
            // ↑ Langsung return user yang sudah ada
        }

        // ================================================
        // SKENARIO 2: USER SUDAH REGISTER MANUAL (EMAIL SAMA)
        // ================================================
        // Cek apakah email sudah terdaftar tapi belum link Google
        // ================================================

        $user = User::where('email', $googleUser->getEmail())->first();
        // ↑ Cari di tabel users WHERE email = '...'

        if ($user) {
            // User dengan email ini sudah ada!
            // Link akun Google ke user yang sudah ada

            $user->update([
                'google_id' => $googleUser->getId(),
                // ↑ Simpan Google ID untuk login berikutnya

                'avatar' => $googleUser->getAvatar() ?? $user->avatar,
                // ↑ Update avatar (gunakan yang lama jika Google tidak ada)

                'email_verified_at' => $user->email_verified_at ?? now(),
                // ↑ Tandai email verified (Google sudah verifikasi)
            ]);

            return $user;
        }

        // ================================================
        // SKENARIO 3: USER BENAR-BENAR BARU
        // ================================================
        // Buat akun baru dengan data dari Google
        // ================================================

        return User::create([
            'name' => $googleUser->getName(),
            // ↑ Nama dari profil Google

            'email' => $googleUser->getEmail(),
            // ↑ Email dari Google (verified)

            'google_id' => $googleUser->getId(),
            // ↑ Google ID untuk login berikutnya

            'avatar' => $googleUser->getAvatar(),
            // ↑ URL foto profil dari Google

            'email_verified_at' => now(),
            // ↑ Langsung verified karena Google sudah verifikasi

            'password' => Hash::make(Str::random(24)),
            // ↑ Generate password random karena user login via Google
            // Str::random(24) = String acak 24 karakter
            // Hash::make()    = Enkripsi agar tidak bisa dibaca
            // User tidak perlu tahu password ini karena login via Google

            'role' => 'customer',
            // ↑ Role default untuk user baru
        ]);
    }
}
