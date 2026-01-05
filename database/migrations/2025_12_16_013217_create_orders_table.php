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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('order_number')->unique(); // ID unik, misal ORD-20231201-001

            // Status Pesanan
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');

            // Status Pembayaran (PENTING: tambahkan ini)
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');

            // Informasi Pengiriman
            $table->string('shipping_name');
            $table->string('shipping_address');
            $table->string('shipping_phone');

            // Total & Biaya
            $table->decimal('total_amount', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);

            // Midtrans Snap Token
            $table->string('snap_token')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
