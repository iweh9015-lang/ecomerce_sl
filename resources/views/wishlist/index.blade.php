{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<style>
    body {
        background-color: #f8fafc;
    }

    .wishlist-header {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2.5rem;
    }

    .wishlist-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: #2563eb;
        border-radius: 2px;
    }

    /* Styling Empty State */
    .empty-wishlist-card {
        background: white;
        border-radius: 2rem;
        padding: 5rem 2rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .icon-circle {
        width: 120px;
        height: 120px;
        background: #eff6ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        font-size: 3rem;
        animation: pulse-blue 2s infinite;
    }

    @keyframes pulse-blue {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
        70% { transform: scale(1); box-shadow: 0 0 0 20px rgba(59, 130, 246, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    .btn-shop {
        background: #2563eb;
        border: none;
        padding: 0.8rem 2.5rem;
        border-radius: 1rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-shop:hover {
        background: #1e40af;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    }
</style>

<div class="container py-5">
    <div class="wishlist-header">
        <h1 class="display-6 fw-black text-dark mb-0">Wishlist Saya</h1>
        <p class="text-muted">Koleksi produk impian yang Anda simpan.</p>
    </div>

    @if($products->count())
        <div class="row row-cols-2 row-cols-md-4 g-4 animate__animated animate__fadeInUp">
            @foreach($products as $product)
                <div class="col">
                    {{-- Komponen card otomatis mengikuti style premium --}}
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-wishlist-card text-center animate__animated animate__zoomIn">
            <div class="icon-circle">
                <i class="bi bi-heart-pulse"></i>
            </div>
            <h2 class="fw-bold text-dark h4">Wah, Wishlist Masih Kosong</h2>
            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                Sepertinya Anda belum menemukan produk yang pas. Jelajahi katalog kami dan temukan penawaran terbaik!
            </p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-shop shadow-lg">
                <i class="bi bi-bag-plus me-2"></i> Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection