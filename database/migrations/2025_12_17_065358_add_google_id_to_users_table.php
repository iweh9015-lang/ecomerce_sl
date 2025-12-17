<?php

// ========================================
// FILE: database/migrations/xxxx_add_google_id_to_users_table.php
// FUNGSI: Menambahkan kolom untuk menyimpan Google user ID
// ========================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migration (menambah kolom).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ================================================
            // KOLOM BARU UNTUK GOOGLE OAUTH
            // ================================================

            $table->string('google_id')->nullable()->after('email');
            // ↑ google_id = ID unik user dari Google
            // nullable()  = Boleh kosong (untuk user yang register manual)
            // after()     = Posisikan setelah kolom email

            $table->string('avatar')->nullable()->after('google_id');
            // ↑ avatar = URL foto profil dari Google
            // nullable() karena user manual mungkin tidak punya avatar

            // ================================================
            // INDEX UNTUK PERFORMA
            // ================================================
            $table->index('google_id');
            // ↑ Index mempercepat pencarian WHERE google_id = '...'
        });
    }

    /**
     * Rollback migration (hapus kolom).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['google_id']);  // Hapus index dulu
            $table->dropColumn(['google_id', 'avatar']);  // Baru hapus kolom
        });
    }
};
