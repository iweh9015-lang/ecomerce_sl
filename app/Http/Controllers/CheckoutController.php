<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil cart user + item + produk
        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        // Jika cart belum ada
        if (!$cart) {
            return view('checkout.index', [
                'cartItems' => collect(),
                'totalPrice' => 0,
            ]);
        }

        $cartItems = $cart->items;

        // Hitung total harga
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function process(Request $request)
    {
        // Nanti kita isi
        return redirect()->route('checkout.index')
            ->with('success', 'Checkout berhasil diproses');
    }
}
