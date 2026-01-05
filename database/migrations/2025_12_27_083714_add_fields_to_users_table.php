<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['customer', 'admin'])
                ->default('customer')
                ->after('password'); // Posisi kolom setelah password

            // Avatar/foto profil
            // Nullable karena user mungkin belum upload foto
            $table->string('avatar')
                ->nullable()
                ->after('role');

            // ID dari Google OAuth (untuk Google Sign-in)
            // Unique agar 1 akun Google hanya bisa connect ke 1 akun di sini
            $table->string('google_id')
                ->nullable()
                ->unique()
                ->after('avatar');

            // Nomor telepon
            // String (bukan interger) karena mungkin mengandung +62 atau spasi
            // Batas 20 karakter cukup untuk nomor internasional
            $table->string('phone', 20)
                ->nullable()
                ->after('google_id');

            // Alamat lengkap
            // Menggunakan TEXT karena alamat bisa sangat panjang (> 255 karakter)
            $table->text('address')
                ->nullable()
                ->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'google_id', 'phone', 'address']);
        });
    }
};
