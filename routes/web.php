<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route; // Baris ini wajib ada

// ==================================================
// HALAMAN PUBLIK
// ==================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Redirect lama
Route::redirect('/products', '/catalog');

// ==================================================
// HALAMAN CUSTOMER (LOGIN)
// ==================================================

Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/process', [CheckoutController::class, 'success'])->name('checkout.process');
    Route::post('/checkout/process', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/proces', [CheckoutController::class, 'process'])->name('checkout.process');
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order}/pending', [OrderController::class, 'pending'])->name('orders.pending');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// ==================================================
// ADMIN ROUTES
// ==================================================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Reports
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');

        // Categories & Products
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class);

        // Orders
        Route::patch('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.update-status');

        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

        // Payment (ADMIN)
        Route::get('/orders/{order}/pay', [PaymentController::class, 'show'])->name('orders.pay');
        Route::get('/orders/{order}/success', [PaymentController::class, 'success'])->name('orders.payment.success');
        Route::get('/orders/{order}/pending', [PaymentController::class, 'pending'])->name('orders.payment.pending');
    });

// ==================================================
// AUTH DEFAULT
// ==================================================

Auth::routes();

// ==================================================
// GOOGLE OAUTH
// ==================================================

Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

// ==================================================
// MIDTRANS WEBHOOK (PUBLIC)
// ==================================================

Route::post('/midtrans/notification', [MidtransNotificationController::class, 'handle'])
    ->name('midtrans.notification');
// Batasi 5 request per menit
