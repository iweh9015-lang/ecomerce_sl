{{-- resources/views/categories/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
<style>
    body {
        background-color: #f8fafc;
    }

    /* Hero Kategori Premium */
    .category-hero {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        padding: 80px 0;
        border-radius: 0 0 50px 50px;
        margin-bottom: -50px;
    }

    /* Card Kategori Style */
    .category-card {
        border: none;
        border-radius: 1.5rem;
        background: #ffffff;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
        border: 1px solid rgba(226, 232, 240, 0.6);
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: #2563eb;
    }

    .category-img-wrapper {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .category-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .category-card:hover .category-img {
        transform: scale(1.1);
    }

    /* Overlay Badge */
    .product-count-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        color: #1e3a8a;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .category-body {
        padding: 1.5rem;
        text-align: center;
    }

    .category-name {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.5rem;
        transition: color 0.3s;
    }

    .category-card:hover .category-name {
        color: #2563eb;
    }

    .btn-explore {
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .category-card:hover .btn-explore {
        color: #2563eb;
    }
</style>

{{-- Hero Section --}}
<section class="category-hero text-white shadow-lg">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-black mb-3 animate__animated animate__fadeInDown">
                    Kategori Produk
                </h1>
                <p class="lead opacity-75 mb-0 animate__animated animate__fadeInUp">
                    Temukan koleksi terbaik kami yang telah dikurasi khusus untuk memenuhi kebutuhan gaya hidup Anda.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Kategori Grid --}}
<section class="py-5" style="margin-top: 20px;">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 animate__animated animate__fadeInUp">
            @foreach ($categories as $category)
            <div class="col">
                <a href="{{ route('categories.show', $category->id) }}" class="text-decoration-none">
                    <div class="card category-card h-100 shadow-sm">
                        <div class="category-img-wrapper">
                            <img src="{{ $category->image_url ?? asset('images/default-category.jpg') }}" 
                                 alt="{{ $category->name }}" 
                                 class="category-img">
                            <span class="product-count-badge">
                                {{ $category->products_count }} Produk
                            </span>
                        </div>
                        <div class="category-body">
                            <h3 class="category-name h5">{{ $category->name }}</h3>
                            <div class="btn-explore">
                                Jelajahi <i class="bi bi-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Paginasi Custom --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

{{-- Bagian Promo Singkat --}}
<section class="container mb-5">
    <div class="p-4 p-md-5 rounded-5 shadow-sm text-center" style="background: white; border: 2px dashed #e2e8f0;">
        <h4 class="fw-bold text-dark">Tidak menemukan kategori yang dicari?</h4>
        <p class="text-muted">Gunakan fitur pencarian untuk menemukan produk spesifik.</p>
        <form action="{{ route('catalog.index') }}" method="GET" class="d-flex justify-content-center mt-3">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="q" class="form-control rounded-pill-start border-primary" placeholder="Cari sesuatu...">
                <button class="btn btn-primary rounded-pill-end px-4" type="submit">Cari</button>
            </div>
        </form>
    </div>
</section>
@endsection