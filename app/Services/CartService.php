<?php

// app/Services/CartService.php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected $cart;

    public function __construct()
    {
        // Ambil keranjang milik user yang sedang login
        $this->cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Ambil keranjang aktif.
     */
    public function getCart()
    {
        return $this->cart->load('items.product');
    }

    /**
     * Tambahkan produk ke keranjang.
     */
    public function addProduct(Product $product, int $quantity = 1)
    {
        $item = $this->cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            // Jika produk sudah ada, tambahkan quantity
            $item->quantity += $quantity;
            $item->save();
        } else {
            // Jika belum ada, buat item baru
            $this->cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }
    }

    /**
     * Update jumlah item.
     */
    public function updateQuantity($itemId, int $quantity)
    {
        $item = $this->cart->items()->findOrFail($itemId);

        if ($quantity <= 0) {
            // Jika quantity 0, hapus item
            $item->delete();
        } else {
            $item->quantity = $quantity;
            $item->save();
        }
    }

    /**
     * Hapus item dari keranjang.
     */
    public function removeItem($itemId)
    {
        $item = $this->cart->items()->findOrFail($itemId);
        $item->delete();
    }

    /**
     * Hitung total harga keranjang.
     */
    public function getTotal()
    {
        return $this->cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}
