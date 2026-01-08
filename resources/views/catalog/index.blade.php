@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    }

    /* Floating Breadcrumb & Back Button */
    .catalog-nav {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-back-home {
        background: white;
        color: #1e293b;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        border-radius: 50rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back-home:hover {
        background: #f1f5f9;
        transform: translateX(-5px);
        color: #2563eb;
    }

    /* Sidebar Filter Premium */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.5rem;
        position: sticky;
        top: 100px;
        transition: box-shadow 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05) !important;
    }

    .filter-title {
        color: #0f172a;
        font-weight: 800;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Badge Category */
    .cat-badge {
        background-color: #f1f5f9;
        color: #64748b;
        font-size: 0.75rem;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-weight: 600;
    }

    /* Custom Radio Styling */
    .form-check-input {
        cursor: pointer;
        width: 1.1rem;
        height: 1.1rem;
        border: 2px solid #cbd5e1;
    }

    .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    }

    /* Price Input Group */
    .price-group {
        position: relative;
    }

    .price-group i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.8rem;
        z-index: 5;
    }

    .price-input {
        padding-left: 2.2rem !important;
    }

    /* Product Header */
    .catalog-header {
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.5px;
    }

    .sort-select {
        min-width: 180px;
        cursor: pointer;
    }

    /* Animasi */
    .product-grid-item {
        animation: fadeInUp 0.5s ease backwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container py-5">
    {{-- NAVIGATION HEADER --}}
    <div class="catalog-nav">
        <a href="{{ route('home') }}" class="btn-back-home shadow-sm">
            <i class="bi bi-arrow-left"></i> Beranda
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">IqbaalStore</a></li>
                <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">Katalog Produk</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card filter-card shadow-sm border-0 p-4">
                <div class="filter-title">
                    <i class="bi bi-sliders2 text-primary"></i> Filter Produk
                </div>
                
                <form action="{{ route('catalog.index') }}" method="GET" id="filterForm">
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                    {{-- Filter Kategori --}}
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-3 d-block">KATEGORI PILIHAN</label>
                        <div class="form-check mb-2 ps-0">
                            <input class="form-check-input d-none" type="radio" name="category" id="cat-all" value="" 
                                   {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label w-100 p-2 rounded-3 d-flex justify-content-between align-items-center {{ !request('category') ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}" 
                                   for="cat-all" style="cursor: pointer;">
                                <span>Semua Produk</span>
                                <i class="bi {{ !request('category') ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>
                            </label>
                        </div>
                        @foreach($categories as $cat)
                        <div class="form-check mb-2 ps-0">
                            <input class="form-check-input d-none" type="radio" name="category" 
                                   id="cat-{{ $cat->slug }}" value="{{ $cat->slug }}" 
                                   {{ request('category')==$cat->slug ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <label class="form-check-label w-100 p-2 rounded-3 d-flex justify-content-between align-items-center {{ request('category')==$cat->slug ? 'bg-primary bg-opacity-10 text-primary fw-bold' : '' }}" 
                                   for="cat-{{ $cat->slug }}" style="cursor: pointer;">
                                <span>{{ $cat->name }}</span>
                                <span class="cat-badge">{{ $cat->products_count }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    {{-- Filter Harga --}}
                    <div class="mb-4">
                        <label class="small fw-bold text-muted mb-3 d-block">RENTANG HARGA</label>
                        <div class="d-flex flex-column gap-3">
                            <div class="price-group">
                                <i>Rp</i>
                                <input type="number" name="min_price" class="form-control form-control-sm price-input border-0 bg-light rounded-3"
                                    placeholder="Harga Minimum" value="{{ request('min_price') }}">
                            </div>
                            <div class="price-group">
                                <i>Rp</i>
                                <input type="number" name="max_price" class="form-control form-control-sm price-input border-0 bg-light rounded-3"
                                    placeholder="Harga Maksimum" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 pt-3">
                        <button type="submit" class="btn btn-primary fw-bold rounded-pill py-2 shadow-sm">
                            Terapkan
                        </button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-link btn-sm text-muted text-decoration-none fw-semibold">
                            Reset Semua
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
                <div>
                    <h2 class="catalog-header mb-1">Koleksi Produk</h2>
                    <p class="text-muted mb-0 small">Menemukan <strong>{{ $products->total() }}</strong> produk berkualitas tinggi</p>
                </div>
                
                {{-- Sorting --}}
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-sort-down text-muted"></i>
                    <form method="GET" class="d-inline-block">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="form-select form-select-sm sort-select border-0 shadow-sm rounded-pill bg-white px-3 fw-semibold" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>✨ Terbaru</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>📉 Termurah</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>📈 Termahal</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($products as $index => $product)
                <div class="col product-grid-item" style="animation-delay: {{ $index * 0.1 }}s">
                    <x-product-card :product="$product" />
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state-card text-center shadow-sm py-5 px-4 bg-white rounded-5 border-0">
                        <div class="mb-4 d-inline-block p-4 bg-light rounded-circle">
                            <i class="bi bi-search text-muted display-4"></i>
                        </div>
                        <h4 class="fw-bold">Produk Tidak Ditemukan</h4>
                        <p class="text-muted mx-auto mb-4" style="max-width: 450px;">
                            Maaf, kami tidak dapat menemukan produk yang sesuai dengan kriteria filter Anda. 
                            Cobalah menggunakan kata kunci lain atau reset filter.
                        </p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary rounded-pill px-5 fw-bold shadow">
                            Lihat Semua Produk
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection