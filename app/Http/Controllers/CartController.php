<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product')->first();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = auth()->user()->cart()->firstOrCreate([]);

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Produk berhasil dimasukkan ke keranjang');
    }

    public function update(Request $request, Product $product)
    {
        $cart = auth()->user()->cart;

        $cart->items()
            ->where('product_id', $product->id)
            ->update(['quantity' => $request->quantity]);

        return back();
    }

    public function remove(Product $product)
    {
        $cart = auth()->user()->cart;

        $cart->items()
            ->where('product_id', $product->id)
            ->delete();

        return back();
    }
}
