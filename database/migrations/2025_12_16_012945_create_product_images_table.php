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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            // Path file gambar di storage
            $table->string('image_path');

            // Gambar utama (tampil di listing)
            $table->boolean('is_primary')->default(false);

            // Urutan tampilan
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            // Index untuk query gambar utama
            $table->index(['product_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
