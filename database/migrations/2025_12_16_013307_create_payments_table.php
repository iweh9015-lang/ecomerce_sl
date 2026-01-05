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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // ID transaksi dari Midtrans
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_order_id')->nullable();

            // Metode pembayaran (gopay, bank_transfer, credit_card, dll)
            $table->string('payment_type', 50)->nullable();

            // Status pembayaran
            $table->enum('status', [
                'pending',  // Menunggu pembayaran
                'success',  // Pembayaran berhasil
                'failed',   // Pembayaran gagal
                'expired',  // Kadaluarsa
                'refunded', // Sudah di-refund
            ])->default('pending');

            // Total yang dibayar
            $table->decimal('gross_amount', 15, 2);

            // Token untuk Midtrans Snap
            $table->string('snap_token')->nullable();

            // URL pembayaran (untuk redirect)
            $table->string('payment_url')->nullable();

            // Waktu kadaluarsa pembayaran
            $table->timestamp('expired_at')->nullable();

            // Waktu pembayaran berhasil
            $table->timestamp('paid_at')->nullable();

            // Raw response dari Midtrans (untuk debugging)
            $table->json('raw_response')->nullable();

            $table->timestamps();

            $table->index('midtrans_transaction_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
