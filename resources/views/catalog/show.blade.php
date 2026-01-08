{{-- resources/views/catalog/show.blade.php --}}

@extends('layouts.app')

@section('title', $product->name)

@section('content')
<style>
    body { background-color: #f8fafc; }

    /* Gallery Styling */
    .product-main-card {
        border: none;
        border-radius: 2rem;
        background: #ffffff;
        overflow: hidden;
    }

    .img-main-wrapper {
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        min-height: 450px;
    }

    .thumb-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid transparent;
    }

    .thumb-img:hover, .thumb-img.active {
        border-color: #2563eb;
        transform: translateY(-3px);
    }

    /* Info Styling */
    .product-title {
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.02em;
    }

    .price-large {
        font-size: 2.25rem;
        font-weight: 900;
        color: #2563eb;
    }

    .price-strike {
        font-size: 1.1rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    /* Action Components */
    .qty-control {
        background: #f1f5f9;
        border-radius: 1rem;
        padding: 5px;
        display: inline-flex;
        align-items: center;
    }

    .qty-btn {
        width: 40px;
        height: 40px;
        border-radius: 0.75rem;
        border: none;
        background: white;
        font-weight: bold;
        transition: all 0.2s;
    }

    .qty-btn:hover { background: #e2e8f0; }

    .btn-buy {
        border-radius: 1rem;
        padding: 0.8rem 2rem;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-buy:not(:disabled):hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    }

    .wishlist-pill {
        width: 50px;
        height: 50px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #f1f5f9;
        transition: all 0.2s;
    }

    .wishlist-pill:hover {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #e11d48;
    }
</style>

<div class="container py-5">
    {{-- Breadcrumb Modern --}}
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb bg-white p-3 rounded-4 shadow-sm px-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active fw-bold text-primary">{{ Str::limit($product->name, 25) }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Sisi Kiri: Galeri Foto --}}
        <div class="col-lg-6">
            <div class="product-main-card shadow-sm">
                <div class="img-main-wrapper position-relative">
                    @if($product->has_discount)
                    <div class="position-absolute top-0 start-0 m-4">
                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">Hemat {{ $product->discount_percentage }}%</span>
                    </div>
                    @endif
                    <img src="{{ $product->image_url }}" id="main-image" class="img-fluid" alt="{{ $product->name }}" style="max-height: 400px; object-fit: contain;">
                </div>
                
                @if($product->images->count() > 1)
                <div class="p-4 bg-white border-top">
                    <div class="d-flex gap-3 overflow-auto pb-2">
                        @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             class="thumb-img border shadow-sm" 
                             onclick="document.getElementById('main-image').src = this.src; document.querySelectorAll('.thumb-img').forEach(i => i.classList.remove('active')); this.classList.add('active');">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Sisi Kanan: Detail & Beli --}}
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" 
                   class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3 fw-bold text-decoration-none">
                    <i class="bi bi-tag-fill me-1"></i> {{ $product->category->name }}
                </a>

                <h1 class="product-title display-5 mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning me-2">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                    </div>
                    <span class="text-muted small fw-medium">4.8 (120+ Ulasan)</span>
                </div>

                <div class="mb-4 p-4 rounded-4 bg-white shadow-sm border">
                    @if($product->has_discount)
                    <div class="price-strike mb-1">{{ $product->formatted_original_price }}</div>
                    @endif
                    <div class="price-large">{{ $product->formatted_price }}</div>
                    
                    <div class="mt-3">
                        @if($product->stock > 10)
                            <span class="text-success fw-bold small"><i class="bi bi-shield-check me-1"></i> Stok Ready & Siap Kirim</span>
                        @elseif($product->stock > 0)
                            <span class="text-warning fw-bold small"><i class="bi bi-exclamation-circle me-1"></i> Stok Terbatas (Sisa {{ $product->stock }})</span>
                        @else
                            <span class="text-danger fw-bold small"><i class="bi bi-x-circle me-1"></i> Maaf, Stok Sedang Kosong</span>
                        @endif
                    </div>
                </div>

                {{-- FORM BELI --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                        <div class="qty-control">
                            <button type="button" class="qty-btn" onclick="decrementQty()">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                   class="form-control border-0 bg-transparent text-center fw-bold" style="width: 60px;">
                            <button type="button" class="qty-btn" onclick="incrementQty()">+</button>
                        </div>

                        <button type="submit" class="btn btn-primary btn-buy btn-lg flex-grow-1" 
                                @if($product->stock == 0) disabled @endif>
                            <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                        </button>

                        @auth
                        <button type="button" onclick="toggleWishlist({{ $product->id }})" 
                                class="wishlist-pill text-muted wishlist-btn-{{ $product->id }}">
                            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-4"></i>
                        </button>
                        @endauth
                    </div>
                </form>

                <hr class="my-5 opacity-50">

                {{-- DESKRIPSI & INFO --}}
                <div class="mb-5">
                    <h5 class="fw-bold text-dark mb-3">Informasi Produk</h5>
                    <div class="text-muted leading-relaxed" style="line-height: 1.8;">
                        {!! $product->description !!}
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 border rounded-4 bg-white d-flex align-items-center">
                            <i class="bi bi-box-seam fs-3 text-primary me-3"></i>
                            <div>
                                <div class="small text-muted">Berat</div>
                                <div class="fw-bold">{{ $product->weight }} gram</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 border rounded-4 bg-white d-flex align-items-center">
                            <i class="bi bi-upc-scan fs-3 text-primary me-3"></i>
                            <div>
                                <div class="small text-muted">SKU</div>
                                <div class="fw-bold">PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
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