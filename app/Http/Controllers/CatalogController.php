<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CatalogController extends Controller
{
    /**
     * Menampilkan semua produk (halaman katalog).
     */
    public function index()
    {
        // Ambil semua produk dengan relasi gambar utama
        $products = Product::with('primaryImage')->paginate(12);

        return view('catalog.index', compact('products'));
    }

    /**
     * Menampilkan detail produk berdasarkan slug atau id.
     */
    public function show(Product $product)
    {
        // Pastikan relasi gambar dan kategori ikut dimuat
        $product->load(['primaryImage', 'category']);

        return view('catalog.show', compact('product'));
    }
}
