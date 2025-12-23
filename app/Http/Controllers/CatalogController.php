<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', 1)
            ->where('stock', '>', 0);

        // FILTER KATEGORI
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // SEARCH NAMA PRODUK
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact('products', 'categories'));
    }
}
