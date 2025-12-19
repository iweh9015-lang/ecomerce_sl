<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if (!$product->is_active || $product->stock <= 0) {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}
