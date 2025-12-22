<?php

// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use App\Models\Product;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman daftar wishlist user.
     */
    public function index()
    {
        // Ambil produk yang di-wishlist oleh user yang sedang login
        $products = auth()->user()->wishlists()
            ->with(['category', 'primaryImage']) // Eager load
            ->latest('wishlists.created_at') // Urutkan dari yang baru di-wishlist
            ->paginate(12);

        return view('wishlist.index', compact('products'));
    }

    /**
     * Toggle wishlist (AJAX handler).
     * Endpoint ini akan dipanggil oleh JavaScript.
     *
     * Konsep Toggle:
     * - Jika user SUDAH like -> Hapus (Unlike/Detach)
     * - Jika user BELUM like -> Tambah (Like/Attach)
     */
    public function toggle(Product $product)
    {
        $user = auth()->user();

        // 1. Cek apakah produk ini ada di daftar wishlist user?
        if ($user->hasInWishlist($product)) {
            // Skenario: User mau UNLIKE
            // detach() menghapus record di tabel pivot (wishlists)
            // berdasarkan user_id dan product_id.
            $user->wishlists()->detach($product->id);

            $added = false; // Indikator untuk frontend: "Hapus warna merah"
            $message = 'Produk dihapus dari wishlist.';
        } else {
            // Skenario: User mau LIKE
            // attach() menambahkan record baru di tabel pivot.
            // Tidak perlu set user_id manual, Laravel otomatis tahu dari $user->wishlists()
            $user->wishlists()->attach($product->id);

            $added = true; // Indikator untuk frontend: "Ubah jadi merah"
            $message = 'Produk ditambahkan ke wishlist!';
        }

        // Return JSON response yang ringan untuk JavaScript
        // Kita kirim status "added" agar JS tahu harus ganti ikon love jadi merah atau abu-abu.
        return response()->json([
            'status' => 'success',
            'added' => $added,
            'message' => $message,
            'count' => $user->wishlists()->count(), // Kirim jumlah terbaru untuk update badge header
        ]);
    }
}
