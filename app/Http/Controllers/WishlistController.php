<?php

namespace App\Http\Controllers;

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

    public function toggle(Request $request, $id)
    {
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$id])) {
            // remove
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);

            return back()->with('success', 'Produk dihapus dari wishlist');
        }

        // add
        $wishlist[$id] = true;
        session()->put('wishlist', $wishlist);

        return back()->with('success', 'Produk ditambahkan ke wishlist');
    }
}
