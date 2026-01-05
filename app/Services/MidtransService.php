<?php

// app/Services/MidtransService.php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    /**
     * Constructor: Inisialisasi konfigurasi Midtrans.
     */
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Membuat Snap Token untuk order tertentu.
     * Snap Token adalah "kunci" yang dipakai frontend untuk menampilkan popup pembayaran.
     *
     * @param Order $order Order yang akan dibayar
     *
     * @return string Snap Token
     *
     * @throws \Exception Jika gagal membuat token
     */
    public function createSnapToken(Order $order): string
    {
        // Validasi order
        if ($order->items->isEmpty()) {
            throw new \Exception('Order tidak memiliki item.');
        }

        // ==================== PARAMETER MIDTRANS SNAP ====================
        // Dokumentasi: https://docs.midtrans.com/en/snap/integration-guide?id=request-body-json-object

        // 1. Transaction Details (WAJIB)
        // 'gross_amount' HARUS integer (Rupiah tidak ada sen di Midtrans).
        // Jangan kirim float/string pecahan!
        $transactionDetails = [
            'order_id' => $order->order_number, // ID Unik Order
            'gross_amount' => (int) $order->total_amount,
        ];

        // 2. Customer Details (Opsional tapi Recommended)
        // Agar data user otomatis terisi di sistem Midtrans (email struk, dll)
        $customerDetails = [
            'first_name' => $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->shipping_phone ?? $order->user->phone ?? '',
            'billing_address' => [
                'first_name' => $order->shipping_name,
                'phone' => $order->shipping_phone,
                'address' => $order->shipping_address,
            ],
            'shipping_address' => [
                'first_name' => $order->shipping_name,
                'phone' => $order->shipping_phone,
                'address' => $order->shipping_address,
            ],
        ];

        // 3. Item Details (Opsional, tapi BAGUS untuk UX)
        // User bisa lihat detail barang apa saja yang dibayar di halaman Midtrans.
        $itemDetails = $order->items->map(function ($item) {
            return [
                'id' => (string) $item->product_id,
                'price' => (int) $item->price, // Harga per item (Harus Integer)
                'quantity' => (int) $item->quantity,
                'name' => substr($item->product_name, 0, 50), // Batasi nama maks 50 char
            ];
        })->toArray();

        // Tambahkan ongkir sebagai item tersendiri jika ada
        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman',
            ];
        }

        // 4. Gabungkan semua parameter
        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        // 5. Request Snap Token ke Server Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);

            return $snapToken;
        } catch (\Exception $e) {
            // Log error untuk debugging di 'storage/logs/laravel.log'
            logger()->error('Midtrans Snap Token Error', [
                'order_id' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Gagal membuat transaksi pembayaran: '.$e->getMessage());
        }
    }

    public function checkStatus(string $orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengecek status: '.$e->getMessage());
        }
    }

    /**
     * Membatalkan transaksi di Midtrans.
     *
     * @param string $orderId Order ID yang dibatalkan
     *
     * @return mixed Response dari Midtrans
     */
    public function cancelTransaction(string $orderId)
    {
        try {
            return Transaction::cancel($orderId);
        } catch (\Exception $e) {
            throw new \Exception('Gagal membatalkan transaksi: '.$e->getMessage());
        }
    }
}
