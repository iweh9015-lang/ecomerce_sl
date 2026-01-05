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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            // INFORMASI DASAR
            $table->string('name');
            $table->string('slug')->unique(); // Slug wajib valid URL dan unik
            $table->text('description')->nullable();

            // HARGA (PENTING!)
            // MENGAPA DECIMAL? Bukan Float?
            // Float tidak presisi untuk uang (bisa terjadi rounding error).
            // Decimal(12, 2) artinya total 12 digit, dengan 2 digit di belakang koma.
            // Contoh valid: 9,999,999,999.99 (Hingga 9 Milyar)
            $table->decimal('price', 12, 2);

            $table->decimal('discount_price', 12, 2)->nullable();

            // STOK BARANG
            $table->integer('stock')->default(0);

            // BERAT BARANG
            // Penting untuk hitung ongkos kirim (misal via JNE/Tiki)
            // Disimpan dalam gram (integer). 1 kg = 1000.
            $table->integer('weight')->default(0)->comment('dalam gram');

            // STATUS VISIBILITAS
            $table->boolean('is_active')->default(true);    // true = tampil di katalog
            $table->boolean('is_featured')->default(false); // true = tampil di carousel/highlight

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
