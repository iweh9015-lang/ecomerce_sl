<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIC
|--------------------------------------------------------------------------
*/

// Root → Beranda
Route::get('/', function () {
    return redirect()->route('beranda');
});

// FIX AUTH HOME
Route::get('/home', function () {
    return redirect()->route('beranda');
})->name('home');

// BERANDA
Route::get('/beranda', [HomeController::class, 'index'])
    ->name('beranda');

// Halaman statis
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| KATALOG (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::get('/catalog', [CatalogController::class, 'index'])
    ->name('catalog.index');

Route::get('/catalog/{product:slug}', [CatalogController::class, 'show'])
    ->name('catalog.show');

/*
|--------------------------------------------------------------------------
| USER (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

// routes/web.php

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
/*
|--------------------------------------------------------------------------
| CART (FIX TANPA PARAM WAJIB DI ROUTE)
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy']);
Route::delete('/cart/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

/*
|--------------------------------------------------------------------------
| WISHLIST
|--------------------------------------------------------------------------
*/

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

/*
|--------------------------------------------------------------------------
| CHECKOUT & ORDER
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

/*
|--------------------------------------------------------------------------
| KATEGORI
|--------------------------------------------------------------------------
*/

Route::get('/categories/{category:slug}', function (Category $category) {
    $products = $category->products()
        ->where('is_active', true)
        ->paginate(12);

    return view('category.show', compact('category', 'products'));
})->name('categories.show');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])
            ->name('dashboard');
        Route::resource('products', AdminCategoryController::class);

        Route::resource('categories', AdminCategoryController::class);
        Route::get('/orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });
//  wishlist

Route::post('/wishlist/{id}', [WishlistController::class, 'toggle'])
    ->name('wishlist.toggle');
// crt
// routes/web.php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kategori
    Route::resource('categories', CategoryController::class)->except(['show']); // Kategori biasanya tidak butuh show detail page

    // Produk
    Route::resource('products', ProductController::class);

    // Route tambahan untuk AJAX Image Handling (jika diperlukan)
    // ...
});
// catalog

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

// Route model binding dengan slug
Route::get('/catalog/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');
// wishlist 2
Route::middleware('auth')->group(function() {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});