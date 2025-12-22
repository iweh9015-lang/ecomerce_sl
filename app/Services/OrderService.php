<?php

// app/Services/OrderService.php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Membuat Order baru dari Keranjang belanja.
     *
     * ALUR PROSES (TRANSACTION):
     * 1. Hitung total & Validasi Stok terakhir
     * 2. Buat Record Order (Header)
     * 3. Pindahkan Cart Items ke Order Items (Detail)
     * 4. Kurangi Stok Produk (Atomic Decrement)
     * 5. Hapus Keranjang
     */
    public function createOrder(User $user, array $shippingData): Order
    {
        // 1. Ambil Keranjang User
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception('Keranjang belanja kosong.');
        }

        // ==================== DATABASE TRANSACTION START ====================
        // Kita menggunakan DB::transaction untuk membungkus semua proses.
        // Jika ada 1 error saja (misal stok kurang saat mau decrement),
        // maka SEMUA query yang sudah jalan akan dibatalkan (Rollback).
        // Order tidak akan terbentuk setengah-setengah.
        return DB::transaction(function () use ($user, $cart, $shippingData) {
            // A. VALIDASI STOK & HITUNG TOTAL
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                // Penting: Cek stok lagi sesaat sebelum memastikan order.
                // Mencegah "Race Condition" jika ada orang lain yang beli barang terakhir detik yang sama.
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }
                $totalAmount += $item->product->price * $item->quantity;
            }

            // B. BUAT HEADER ORDER
            $order = Order::create([
                'user_id' => $user->id,
                // Generate Order Number Unik. Contoh: ORD-X7Y8Z9A1B2
                'order_number' => 'ORD-'.strtoupper(Str::random(10)),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_name' => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone' => $shippingData['phone'],
                'total_amount' => $totalAmount,
            ]);

            // C. PINDAHKAN ITEMS
            foreach ($cart->items as $item) {
                // Buat Order Item
                $order->items()->create([
                    'product_id' => $item->product_id,

                    // SNAPSHOT DATA (PENTING!)
                    // Kita simpan nama & harga barang SAAT INI ke tabel order_items.
                    // Tujuannya: Jika besok admin ubah harga/nama produk,
                    // data di historical order user TIDAK IKUT BERUBAH.
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,

                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);

                // D. KURANGI STOK (ATOMIC)
                // decrement() menjalankan query: UPDATE products SET stock = stock - X
                // Ini thread-safe di level database.
                $item->product->decrement('stock', $item->quantity);
            }

            // E. BERSIHKAN KERANJANG
            // Hapus semua item di keranjang user karena sudah jadi order.
            $cart->items()->delete();

            // Opsional: Hapus object cart-nya juga jika ingin reset session total
            // $cart->delete();

            return $order;
        });
        // ==================== DATABASE TRANSACTION END ====================
    }
}
