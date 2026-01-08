@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Hero Section - Pro Version */
    .hero-gradient {
        background: linear-gradient(-45deg, #0f172a, #1e3a8a, #2563eb, #000000);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
        border-radius: 0 0 4rem 4rem;
        padding: 120px 0;
        position: relative;
        overflow: hidden;
    }

    /* Ornamen Cahaya di Background */
    .hero-gradient::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(37, 99, 235, 0.4);
        filter: blur(100px);
        top: 10%;
        right: 10%;
        z-index: 0;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Glassmorphism Stats */
    .stats-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1rem;
        border-radius: 1.5rem;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }

    /* Category Pro Styling */
    .category-card {
        border: none;
        background: white;
        border-radius: 2rem;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .category-card:hover {
        transform: translateY(-15px) rotate(2deg);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }

    .category-img-wrapper {
        width: 110px;
        height: 110px;
        padding: 8px;
        background: #f1f5f9;
        border-radius: 50%;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-img-wrapper {
        background: #dbeafe;
    }

    /* Section Title Pro */
    .section-title {
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -1px;
        font-size: 2.5rem;
    }

    .section-subtitle {
        color: #64748b;
        font-size: 1.1rem;
        margin-bottom: 3rem;
    }

    /* Promo Card Pro */
    .promo-card {
        border-radius: 2.5rem;
        transition: transform 0.3s ease;
    }

    .promo-card:hover {
        transform: scale(1.02);
    }
</style>

{{-- Hero Section --}}
<section class="hero-gradient text-white mb-5">
    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-6 animate__animated animate__fadeInLeft">
                <div class="stats-card mb-4 animate__animated animate__fadeInDown animate__delay-1s">
                    <i class="bi bi-patch-check-fill text-info"></i>
                    <span>Toko Digital Terpercaya & Terverifikasi</span>
                </div>
                
                <h1 class="display-2 fw-bolder mb-3 text-white">
                    Upgrade Gadgetmu <br><span class="text-info">Tanpa Batas.</span>
                </h1>
                
                <p class="lead mb-5 opacity-75 pe-lg-5">
                    Dapatkan akses eksklusif ke teknologi terbaru dengan jaminan originalitas dan layanan purna jual terbaik di Indonesia.
                </p>
                
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('catalog.index') }}" class="btn btn-info btn-lg rounded-pill px-5 fw-bold shadow-lg text-white">
                        Belanja Sekarang <i class="bi bi-bag-plus ms-2"></i>
                    </a>
                    <a href="#featured" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="bi bi-stars me-2"></i> Produk Hot
                    </a>
                </div>

                {{-- Social Proof --}}
                <div class="mt-5 d-flex align-items-center gap-3 opacity-75">
                    <div class="avatar-group d-flex">
                        <img src="https://i.pravatar.cc/40?img=1" class="rounded-circle border border-2 border-white" width="35">
                        <img src="https://i.pravatar.cc/40?img=2" class="rounded-circle border border-2 border-white ms-n2" width="35">
                        <img src="https://i.pravatar.cc/40?img=3" class="rounded-circle border border-2 border-white ms-n2" width="35">
                    </div>
                    <span class="small fw-medium">10k+ Pelanggan Puas</span>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block text-center animate__animated animate__zoomIn">
                {{-- Gunakan mockup yang lebih modern jika ada, atau tambahkan shadow --}}
                <img src="{{ asset('images/house.png') }}" alt="Hero" class="img-fluid floating-animation"
                    style="max-height: 480px; filter: drop-shadow(0 30px 60px rgba(0,0,0,0.5));">
            </div>
        </div>
    </div>
</section>

{{-- Kategori Populer --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Pilihan</h2>
            <p class="section-subtitle">Pilih perangkat yang sesuai dengan passion Anda</p>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2 animate__animated animate__fadeInUp">
                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                    <div class="card category-card shadow-sm h-100 py-4 text-center">
                        <div class="card-body">
                            <div class="category-img-wrapper mx-auto d-flex align-items-center justify-content-center">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                    class="rounded-circle shadow-sm" width="100%" height="100%" style="object-fit: cover;">
                            </div>
                            <h6 class="fw-bold text-dark mb-2">{{ $category->name }}</h6>
                            <p class="text-muted small mb-0">{{ $category->products_count }} Produk</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Promo Banner Pro --}}
<section id="promo" class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card promo-card border-0 shadow-lg overflow-hidden position-relative" style="background: #2563eb; min-height: 280px;">
                    <div class="card-body p-5 d-flex flex-column justify-content-center text-white position-relative" style="z-index: 2;">
                        <span class="badge bg-warning text-dark mb-3 fw-bold rounded-pill" style="width: fit-content;">LIMIT TIME</span>
                        <h2 class="display-6 fw-black">Flash Sale ⚡</h2>
                        <p class="opacity-75 mb-4">Potongan harga hingga 50% untuk aksesoris gaming.</p>
                        <a href="#" class="btn btn-light rounded-pill fw-bold px-4" style="width: fit-content;">Klaim Sekarang</a>
                    </div>
                    {{-- Dekorasi Circle --}}
                    <div class="position-absolute end-0 bottom-0 opacity-25" style="transform: translate(20%, 20%);">
                        <i class="bi bi-lightning-fill text-white" style="font-size: 15rem;"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card promo-card border-0 shadow-lg overflow-hidden position-relative" style="background: #0ea5e9; min-height: 280px;">
                    <div class="card-body p-5 d-flex flex-column justify-content-center text-white position-relative" style="z-index: 2;">
                        <span class="badge bg-white text-info mb-3 fw-bold rounded-pill" style="width: fit-content;">MEMBER ONLY</span>
                        <h2 class="display-6 fw-black">Gratis Ongkir! 🚚</h2>
                        <p class="opacity-75 mb-4">Khusus pengiriman di seluruh wilayah Pulau Jawa.</p>
                        <a href="{{ route('register') }}" class="btn btn-dark rounded-pill fw-bold px-4" style="width: fit-content;">Daftar Member</a>
                    </div>
                    <div class="position-absolute end-0 bottom-0 opacity-25" style="transform: translate(10%, 10%);">
                        <i class="bi bi-truck text-white" style="font-size: 12rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Produk Unggulan Pro --}}
<section id="featured" class="py-5">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5">
            <div>
                <span class="text-primary fw-bold text-uppercase small tracking-widest">Editor's Choice</span>
                <h2 class="section-title mb-0">Produk Unggulan</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-link text-decoration-none fw-bold p-0 mt-3 mt-md-0">
                Lihat Koleksi Lengkap <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-wrapper animate__animated animate__fadeIn">
                     @include('partials.product-card', ['product' => $product])
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Smooth scroll for anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Enhanced floating animation
    document.addEventListener('DOMContentLoaded', function() {
        const img = document.querySelector('.floating-animation');
        let pos = 0;
        function animate() {
            pos += 0.04;
            const y = Math.sin(pos) * 20;
            const rotate = Math.cos(pos) * 2;
            img.style.transform = `translateY(${y}px) rotate(${rotate}deg)`;
            requestAnimationFrame(animate);
        }
        animate();
    });
</script>
@endpush
@endsection