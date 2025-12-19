<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WishlistController extends Controller
{
    // Method untuk menampilkan daftar wishlist
    public function index()
    {
        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Menampilkan produk-produk yang ada di wishlist pengguna
        $items = $user->wishlist()->with('product')->get();

        return view('wishlist.index', compact('items'));  // Pastikan ada view 'wishlist.index'
    }

    public function toggle($productId)
    {
        // Mendapatkan produk berdasarkan ID
        $product = Product::findOrFail($productId);

        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Cek apakah produk sudah ada di wishlist
        $wishlistExists = $user->wishlists()->where('product_id', $product->id)->exists();

        if ($wishlistExists) {
            // Jika sudah ada, hapus produk dari wishlist
            $user->wishlists()->detach($product->id);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari wishlist',
                'added' => false,  // Menunjukkan bahwa produk sudah dihapus
            ]);
        } else {
            // Jika belum ada, tambahkan produk ke wishlist
            $user->wishlists()->attach($product->id);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke wishlist',
                'added' => true,  // Menunjukkan bahwa produk berhasil ditambahkan
            ]);
        }
    }
}
