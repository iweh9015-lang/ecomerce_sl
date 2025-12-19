{{-- ================================================
     FILE: resources/views/catalog/show.blade.php
     FUNGSI: Halaman detail produk
     ================================================ --}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Katalog</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Product Images --}}
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                {{-- Main Image --}}
                <div class="position-relative">
                    <img src="{{ $product->image_url }}"
                         id="main-image"
                         class="card-img-top"
                         alt="{{ $product->name }}"
                         style="height: 400px; object-fit: contain; background: #f8f9fa;">

                    @if($product->has_discount)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-3 fs-6">
                            -{{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                {{-- Thumbnail Gallery --}}
                @if($product->images->count() > 1)
                    <div class="card-body">
                        <div class="d-flex gap-2 overflow-auto">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     class="rounded border cursor-pointer"
                                     style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                     onclick="document.getElementById('main-image').src = this.src">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    {{-- Category --}}
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
                       class="badge bg-light text-dark text-decoration-none mb-2">
                        {{ $product->category->name }}
                    </a>

                    {{-- Title --}}
                    <h2 class="mb-3">{{ $product->name }}</h2>

                    {{-- Price --}}
                    <div class="mb-4">
                        @if($product->has_discount)
                            <div class="text-muted text-decoration-line-through">
                                {{ $product->formatted_original_price }}
                            </div>
                        @endif
                        <div class="h3 text-primary fw-bold mb-0">
                            {{ $product->formatted_price }}
                        </div>
                    </div>

                    {{-- Stock Status --}}
                    <div class="mb-4">
                        @if($product->stock > 10)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i> Stok Tersedia
                            </span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-exclamation-triangle me-1"></i> Stok Tinggal {{ $product->stock }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i> Stok Habis
                            </span>
                        @endif
                    </div>

                    {{-- Add to Cart Form --}}
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-3 align-items-end">
                            <div class="col-auto">
                                <label class="form-label">Jumlah</label>
                                <div class="input-group" style="width: 140px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="decrementQty()">-</button>
                                    <input type="number" name="quantity" id="quantity"
                                           value="1" min="1" max="{{ $product->stock }}"
                                           class="form-control text-center">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg w-100"
                                        @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-cart-plus me-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Wishlist --}}
                    @auth
                        <button type="button"
                                onclick="toggleWishlist({{ $product->id }})"
                                class="btn btn-outline-danger mb-4 wishlist-btn-{{ $product->id }}">
                            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                            {{ auth()->user()->hasInWishlist($product) ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}
                        </button>
                    @endauth

                    <hr>

                    {{-- Product Details --}}
                    <div class="mb-3">
                        <h6>Deskripsi</h6>
                        <p class="text-muted">{!! nl2br(e($product->description)) !!}</p>
                    </div>

                    <div class="row text-muted small">
                        <div class="col-6 mb-2">
                            <i class="bi bi-box me-2"></i> Berat: {{ $product->weight }} gram
                        </div>
                        <div class="col-6 mb-2">
                            <i class="bi bi-tag me-2"></i> SKU: PROD-{{ $product->id }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endpush
@endsection