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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Nama kategori, max 100 karakter
            $table->string('name', 100);

            // Slug untuk URL-friendly (contoh: fashion-pria)
            // Unique agar tidak ada duplikat
            $table->string('slug', 100)->unique();

            // Deskripsi kategori (opsional)
            $table->text('description')->nullable();

            // Path gambar kategori (opsional)
            $table->string('image')->nullable();

            // Status aktif/nonaktif
            $table->boolean('is_active')->default(true);

            // Created_at dan updated_at
            $table->timestamps();

            // Index untuk pencarian yang lebih cepat
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
