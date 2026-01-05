<?php

// app/Services/CartService.php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Mendapatkan (atau membuat) keranjang untuk user saat ini.
     * Menggunakan Session ID untuk guest, dan User ID untuk member.
     */
    public function getCart(): Cart
    {
        if (Auth::check()) {
            // Skenario 1: User Login
            // Kita cari cart milik user ini. Jika belum ada, buat baru.
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            // Skenario 2: Guest (Belum Login)
            // Kita gunakan Session ID bawaan Laravel sebagai penanda unik.
            // Session ID ini tersimpan di cookie browser user.
            $sessionId = Session::getId();

            return Cart::firstOrCreate(['session_id' => $sessionId]);
        }
    }

    /**
     * Menambahkan produk ke keranjang.
     * Handle logika: Baru vs Existing, dan Cek Stok.
     */
    public function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();

        // Cek apakah produk sudah ada di keranjang kita?
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            // CASE A: Produk SUDAH ADA, update jumlahnya
            $newQuantity = $existingItem->quantity + $quantity;

            // Validasi Stok (Penting!)
            // Jangan sampai user memasukkan barang melebihi stok gudang.
            if ($newQuantity > $product->stock) {
                throw new \Exception("Stok tidak mencukupi. Maksimal: {$product->stock}");
            }

            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            // CASE B: Produk BARU, buat item baru
            // Validasi Stok Awal
            if ($quantity > $product->stock) {
                throw new \Exception('Stok tidak mencukupi.');
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        // Update timestamp 'updated_at' di tabel carts
        // Berguna untuk fitur "Hapus keranjang sampah/lama" (Garbage Collection) nanti.
        $cart->touch();
    }

    /**
     * Mengupdate jumlah item (misal dari halaman keranjang).
     */
    public function updateQuantity(int $itemId, int $quantity): void
    {
        $item = CartItem::findOrFail($itemId);
        $product = $item->product;

        // Security Check: Pastikan item ini MILIK cart user yang sedang login/aktif.
        // Mencegah user iseng mengedit ID item milik orang lain.
        $this->verifyCartOwnership($item->cart);

        // Validasi Stok Real-time
        if ($quantity > $product->stock) {
            throw new \Exception("Stok tidak mencukupi. Tersisa: {$product->stock}");
        }

        if ($quantity <= 0) {
            $item->delete(); // Jika diupdate jadi 0 atau minus, hapus saja.
        } else {
            $item->update(['quantity' => $quantity]);
        }
    }

    /**
     * Menghapus item dari keranjang.
     */
    public function removeItem(int $itemId): void
    {
        $item = CartItem::findOrFail($itemId);

        // Security Check lagi
        $this->verifyCartOwnership($item->cart);

        $item->delete();
    }

    /**
     * Menggabungkan keranjang Guest ke User saat Login.
     * Logika: "Pindahkan" belanjaan saat jadi tamu ke akun asli.
     */
    public function mergeCartOnLogin(): void
    {
        // 1. Ambil cart sesi tamu (sebelum session ID diregenerate login)
        $sessionId = Session::getId();
        $guestCart = Cart::where('session_id', $sessionId)->with('items')->first();

        // Jika tidak ada belanjaan tamu, selesai.
        if (!$guestCart) {
            return;
        }

        // 2. Ambil/Buat cart user yang baru login (tujuan)
        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // 3. Loop setiap item tamu
        foreach ($guestCart->items as $item) {
            // Cek apakah produk ini SUDAH ADA di cart user?
            $existingUserItem = $userCart->items()
                ->where('product_id', $item->product_id)
                ->first();

            if ($existingUserItem) {
                // Skenario: User sudah punya produk X, Tamu juga punya produk X.
                // Solusi: Tambahkan quantity (Merge)
                $existingUserItem->increment('quantity', $item->quantity);
            } else {
                // Skenario: User belum punya.
                // Solusi: Pindahkan kepemilikan item ke cart user.
                $item->update(['cart_id' => $userCart->id]);
            }
        }

        // 4. Hapus gerobak tamu yang sudah kosong/dipindahkan
        $guestCart->delete();
    }

    /**
     * Helper untuk memastikan user berhak mengubah cart ini
     * Mencegah Insecure Direct Object Reference (IDOR).
     */
    private function verifyCartOwnership(Cart $cart): void
    {
        $currentCart = $this->getCart();
        // Bandingkan ID cart yang mau diedit dengan ID cart user saat ini
        if ($cart->id !== $currentCart->id) {
            abort(403, 'Akses ditolak. Ini bukan keranjang Anda.');
        }
    }
}
