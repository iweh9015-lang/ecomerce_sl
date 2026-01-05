<?php

namespace App\Http\Controllers;

use App\Events\OrderPaidEvent;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans Notification Received', $payload);

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;

        if (!$orderId || !$transactionStatus || !$signatureKey) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // ===== VALIDASI SIGNATURE =====
        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash(
            'sha512',
            $orderId.$statusCode.$grossAmount.$serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // ===== IDEMPOTENCY CHECK =====
        if (in_array($order->status, ['processing', 'shipped', 'delivered', 'cancelled'])) {
            return response()->json(['message' => 'Order already processed'], 200);
        }

        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'midtrans_transaction_id' => $transactionId,
                'payment_type' => $paymentType,
                'raw_response' => json_encode($payload),
            ]);
        }

        // ===== STATUS HANDLING =====
        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus === 'challenge') {
                    $this->handlePending($order, $payment, 'Menunggu review fraud');
                } else {
                    $this->handleSuccess($order, $payment);
                }
                break;

            case 'settlement':
                $this->handleSuccess($order, $payment);
                break;

            case 'pending':
                $this->handlePending($order, $payment, 'Menunggu pembayaran');
                break;

            case 'deny':
            case 'expire':
            case 'cancel':
                $this->handleFailed($order, $payment, 'Pembayaran gagal');
                break;

            case 'refund':
            case 'partial_refund':
                $this->handleRefund($order, $payment);
                break;
        }

        return response()->json(['message' => 'Notification processed'], 200);
    }

    /**
     * Handle pembayaran sukses.
     */
    protected function handleSuccess(Order $order, ?Payment $payment): void
    {
        Log::info("Payment SUCCESS for Order: {$order->order_number}");

        // Update payment
        if ($payment) {
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
            ]);
        }

        // Set success + fire event
        $this->setSuccess($order);
    }

    /**
     * SET ORDER SUCCESS + FIRE EVENT.
     */
    private function setSuccess(Order $order): void
    {
        $order->update([
            'status' => 'processing',
            'payment_status' => 'paid',
        ]);

        // 🔥 Fire & Forget Event
        event(new OrderPaidEvent($order));
    }

    protected function handlePending(Order $order, ?Payment $payment, string $message = ''): void
    {
        Log::info("Payment PENDING for Order: {$order->order_number}", [
            'message' => $message,
        ]);

        if ($payment) {
            $payment->update(['status' => 'pending']);
        }
    }

    protected function handleFailed(Order $order, ?Payment $payment, string $reason = ''): void
    {
        Log::info("Payment FAILED for Order: {$order->order_number}", [
            'reason' => $reason,
        ]);

        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed',
        ]);

        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        // RESTOCK
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }
    }

    protected function handleRefund(Order $order, ?Payment $payment): void
    {
        Log::info("Payment REFUNDED for Order: {$order->order_number}");

        if ($payment) {
            $payment->update(['status' => 'refunded']);
        }
    }
}
