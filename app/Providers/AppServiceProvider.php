<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;              // ✅ BENAR
use Illuminate\Support\ServiceProvider;   // (kalau pakai observer)

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Product::observe(ProductObserver::class);
    }
}
