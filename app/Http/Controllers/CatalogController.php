<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->paginate(9);

        $categories = Category::where('is_active', true)->get();

        return view('catalog.index', compact('products', 'categories'));
    }
}
