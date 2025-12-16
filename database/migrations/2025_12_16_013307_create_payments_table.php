<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_order_id')->nullable();

            $table->string('payment_type', 50)->nullable();

            $table->enum('status', [
                'pending',
                'success',
                'failed',
                'expired',
                'refunded',
            ])->default('pending');

            $table->decimal('gross_amount', 15, 2);

            $table->string('snap_token')->nullable();

            $table->string('payment_url')->nullable();

            $table->timestamp('expired_at')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->json('raw_response')->nullable();

            $table->timestamps();

            $table->index('midtrans_transaction_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
