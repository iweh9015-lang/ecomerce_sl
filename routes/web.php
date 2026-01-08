<?php

// ================================================
// FILE: routes/web.php
// FUNGSI: Definisi semua route website
// ================================================

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;

// ================================================
// HALAMAN PUBLIK (Tanpa Login)
// ================================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Katalog Produk
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// ================================================
// HALAMAN YANG BUTUH LOGIN (Customer)
// ================================================

Route::middleware('auth')->group(function () {
    // Keranjang Belanja
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

    // Pesanan Saya
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order}/pending', [OrderController::class, 'pending'])->name('orders.pending');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// ================================================
// HALAMAN ADMIN (Butuh Login + Role Admin)
// ================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Laporan Penjualan
    Route::get('/reports/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
    // Update status pesanan
    Route::patch('/orders/{order}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori CRUD (Resource sudah mencakup index, create, store, edit, update, destroy)
    Route::resource('categories', CategoryController::class);

    // Produk CRUD
    Route::resource('products', ProductController::class);

    // Pesanan
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::patch('/orders/{order}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Laporan
    Route::get('/reports/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('reports.sales');
});

// Resource route untuk orders (index, show, update)
Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);

// ================================================
// AUTH ROUTES (dari Laravel UI)
// ================================================
Auth::routes();

use Illuminate\Support\Facades\Route;

// ================================================
// GOOGLE OAUTH ROUTES
// ================================================
// Route ini diakses oleh browser, tidak perlu middleware auth
// ================================================

Route::controller(GoogleController::class)->group(function () {
    // ================================================
    // ROUTE 1: REDIRECT KE GOOGLE
    // ================================================
    // URL: /auth/google
    // Dipanggil saat user klik tombol "Login dengan Google"
    // ================================================
    Route::get('/auth/google', 'redirect')
        ->name('auth.google');

    // ================================================
    // ROUTE 2: CALLBACK DARI GOOGLE
    // ================================================
    // URL: /auth/google/callback
    // Dipanggil oleh Google setelah user klik "Allow"
    // URL ini HARUS sama dengan yang didaftarkan di Google Console!
    // ================================================
    Route::get('/auth/google/callback', 'callback')
        ->name('auth.google.callback');
});

Route::post('midtrans/notification', [MidtransNotificationController::class, 'handle'])
    ->name('midtrans.notification');
