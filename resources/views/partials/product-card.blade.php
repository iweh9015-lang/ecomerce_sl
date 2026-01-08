{{-- resources/views/partials/product-card.blade.php --}}

<div class="card h-100 border-0 shadow-sm product-card-hover overflow-hidden rounded-4">
    {{-- Product Image Container --}}
    <div class="position-relative overflow-hidden">
        <a href="{{ route('catalog.show', $product->slug) }}">
            <img src="{{ $product->image_url }}" 
                 class="card-img-top img-zoom" 
                 alt="{{ $product->name }}"
                 style="height: 220px; object-fit: cover;">
        </a>

        {{-- Badge Diskon (Lebih menonjol) --}}
        @if($product->has_discount)
        <span class="badge bg-danger position-absolute top-0 start-0 m-3 rounded-pill px-3 shadow-sm">
            -{{ $product->discount_percentage }}%
        </span>
        @endif

        {{-- Wishlist Button (Glassmorphism Effect) --}}
        @auth
        <button type="button" onclick="toggleWishlist({{ $product->id }})"
            class="btn btn-wishlist position-absolute top-0 end-0 m-3 rounded-circle shadow-sm wishlist-btn-{{ $product->id }}">
            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
        </button>
        @endauth
    </div>

    {{-- Card Body --}}
    <div class="card-body p-3 d-flex flex-column">
        {{-- Category --}}
        <div class="mb-1 text-uppercase text-primary fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">
            {{ $product->category->name }}
        </div>

        {{-- Product Name --}}
        <h6 class="card-title mb-2 lh-base">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-dark fw-semibold stretched-link">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        {{-- Price Area --}}
        <div class="mt-auto pt-2">
            @if($product->has_discount)
            <div class="text-muted text-decoration-line-through small" style="font-size: 0.75rem;">
                {{ $product->formatted_original_price }}
            </div>
            @endif
            <div class="fs-5 fw-bold text-dark">
                {{ $product->formatted_price }}
            </div>
        </div>

        {{-- Stock Info Indicator --}}
        <div class="mt-2">
            @if($product->stock <= 5 && $product->stock > 0)
                <div class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill w-100 py-1" style="font-size: 0.7rem;">
                    <i class="bi bi-clock-history me-1"></i> Stok terbatas!
                </div>
            @elseif($product->stock == 0)
                <div class="badge bg-light text-muted border rounded-pill w-100 py-1" style="font-size: 0.7rem;">
                    <i class="bi bi-x-circle me-1"></i> Habis
                </div>
            @endif
        </div>
    </div>

    {{-- Card Footer --}}
    <div class="card-footer bg-white border-0 p-3 pt-0" style="z-index: 2;">
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-bold shadow-sm btn-cart-animate" 
                    @if($product->stock == 0) disabled @endif>
                @if($product->stock == 0)
                    Sudah Terjual
                @else
                    <i class="bi bi-cart-plus me-2"></i>+ Keranjang
                @endif
            </button>
        </form>
    </div>
</div>

<style>
    /* Efek hover pada seluruh kartu */
    .product-card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .product-card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.12) !important;
    }

    /* Efek zoom pada gambar saat di-hover */
    .img-zoom {
        transition: transform 0.5s ease;
    }
    .product-card-hover:hover .img-zoom {
        transform: scale(1.1);
    }

    /* Gaya tombol Wishlist transparan (Glassmorphism) */
    .btn-wishlist {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(4px);
        border: none;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }
    .btn-wishlist:hover {
        background: #fff;
        transform: scale(1.1);
    }

    /* Animasi tombol keranjang */
    .btn-cart-animate {
        transition: all 0.2s ease;
    }
    .btn-cart-animate:hover {
        filter: brightness(1.1);
        letter-spacing: 0.5px;
    }
</style>