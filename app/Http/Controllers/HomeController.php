<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->active()
            ->withCount([
                'activeProducts as active_products_count' => function ($q) {
                    $q->where('is_active', true)
                      ->where('stock', '>', 0);
                },
            ])
            ->having('active_products_count', '>', 0)
            ->orderBy('name')
            ->take(6)
            ->get();

        $featuredProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        return view('home', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
        ]);
    }
}
