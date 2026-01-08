{{-- resources/views/catalog/show.blade.php atau sesuai route Anda --}}
@extends('layouts.app')

@section('title', $product->name ?? 'Detail Produk')

@section('content')
<style>
    body { background-color: #f8fafc; }

    /* Product Gallery */
    .product-img-wrapper {
        background: white;
        border-radius: 2rem;
        padding: 20px;
        position: sticky;
        top: 100px;
        transition: all 0.3s ease;
    }

    .main-img {
        width: 100%;
        border-radius: 1.5rem;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-img-wrapper:hover .main-img {
        transform: scale(1.02);
    }

    /* Information Section */
    .product-info-card {
        padding-left: 20px;
    }

    .badge-category {
        background: #eff6ff;
        color: #2563eb;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .product-title {
        font-weight: 900;
        color: #1e293b;
        font-size: 2.5rem;
        line-height: 1.2;
    }

    .price-tag {
        font-size: 2rem;
        font-weight: 800;
        color: #2563eb;
        margin: 1.5rem 0;
    }

    .stock-status {
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Action Buttons */
    .btn-cart {
        padding: 1rem 2rem;
        border-radius: 1rem;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-wishlist-detail {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        border: 2px solid #e2e8f0;
        color: #64748b;
        transition: all 0.3s;
    }

    .btn-wishlist-detail:hover {
        background: #fff1f2;
        color: #f43f5e;
        border-color: #f43f5e;
    }

    /* Description Tab */
    .nav-tabs-premium {
        border: none;
        gap: 10px;
    }

    .nav-tabs-premium .nav-link {
        border: none;
        color: #64748b;
        font-weight: 700;
        padding: 10px 25px;
        border-radius: 10px;
    }

    .nav-tabs-premium .nav-link.active {
        background: #2563eb;
        color: white;
    }
</style>

<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4 animate__animated animate__fadeIn">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none">Katalog</a></li>
            <li class="breadcrumb-item active">{{ $product->category->name ?? 'Kategori' }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Sisi Kiri: Gambar --}}
        <div class="col-lg-6">
            <div class="product-img-wrapper shadow-sm animate__animated animate__fadeInLeft">
                <img src="{{ $product->image_url ?? asset('images/default-product.jpg') }}" 
                     alt="{{ $product->name }}" 
                     class="main-img">
            </div>
        </div>

        {{-- Sisi Kanan: Detail --}}
        <div class="col-lg-6">
            <div class="product-info-card animate__animated animate__fadeInRight">
                <span class="badge-category">
                    <i class="bi bi-tag-fill me-2"></i>{{ $product->category->name ?? 'Uncategorized' }}
                </span>
                
                <h1 class="product-title mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning me-2">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <span class="text-muted small">(4.5 Rating dari pelanggan)</span>
                </div>

                <div class="price-tag">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="mb-4">
                    @if($product->stock > 0)
                        <span class="stock-status text-success">
                            <i class="bi bi-check-circle-fill me-1"></i> Stok Tersedia ({{ $product->stock }} unit)
                        </span>
                    @else
                        <span class="stock-status text-danger">
                            <i class="bi bi-x-circle-fill me-1"></i> Stok Habis
                        </span>
                    @endif
                </div>

                <p class="text-muted mb-5 leading-relaxed">
                    {{ Str::limit($product->description, 200) }}
                </p>

                {{-- Form Add to Cart --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="d-flex gap-3 align-items-center mb-5">
                        <div class="quantity-input" style="width: 120px;">
                            <input type="number" name="quantity" class="form-control form-control-lg text-center rounded-3 fw-bold" value="1" min="1" max="{{ $product->stock }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-cart flex-grow-1 shadow-lg">
                            <i class="bi bi-cart-plus me-2"></i> Masukkan Keranjang
                        </button>
                        <a href="#" class="btn-wishlist-detail" title="Tambah ke Wishlist">
                            <i class="bi bi-heart-fill"></i>
                        </a>
                    </div>
                </form>

                {{-- Fitur Unggulan --}}
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center p-3 rounded-4 border bg-white shadow-sm">
                            <i class="bi bi-truck fs-3 text-primary me-3"></i>
                            <span class="small fw-bold text-dark">Pengiriman Cepat</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center p-3 rounded-4 border bg-white shadow-sm">
                            <i class="bi bi-shield-check fs-3 text-primary me-3"></i>
                            <span class="small fw-bold text-dark">Garansi Resmi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Deskripsi Lengkap --}}
    <div class="mt-5 pt-5 animate__animated animate__fadeInUp">
        <ul class="nav nav-tabs nav-tabs-premium mb-4" id="productTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc">Deskripsi Lengkap</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="spec-tab" data-bs-toggle="tab" data-bs-target="#spec">Spesifikasi</button>
            </li>
        </ul>
        <div class="tab-content bg-white p-4 rounded-4 shadow-sm border">
            <div class="tab-pane fade show active" id="desc">
                <p class="mb-0 text-muted" style="line-height: 1.8;">
                    {{ $product->description }}
                </p>
            </div>
            <div class="tab-pane fade" id="spec">
                <table class="table table-striped mb-0">
                    <tr>
                        <td class="fw-bold" style="width: 200px;">Kondisi</td>
                        <td>Baru (Original)</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Berat</td>
                        <td>1.2 kg</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Garansi</td>
                        <td>12 Bulan Seller Warranty</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection