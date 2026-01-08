{{-- resources/views/components/product-card.blade.php --}}
@props(['product'])

<style>
    .product-card {
        border-radius: 1.25rem !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.08) !important;
    }

    .img-zoom-container {
        overflow: hidden;
        border-radius: 1.25rem 1.25rem 0 0;
    }

    .product-card img {
        transition: transform 0.6s ease;
    }

    .product-card:hover img {
        transform: scale(1.1);
    }

    .wishlist-btn-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.8);
        border: none;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
    }

    .wishlist-btn-overlay:hover {
        background: #ffffff;
        transform: scale(1.1);
    }

    .price-text {
        font-size: 1.1rem;
        letter-spacing: -0.02em;
    }

    .category-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #94a3b8;
    }
</style>

<div class="card h-100 border-0 shadow-sm product-card position-relative">
    {{-- Overlay Wishlist --}}
    <button onclick="event.preventDefault(); toggleWishlist({{ $product->id }})"
        class="wishlist-btn-overlay wishlist-btn-{{ $product->id }}">
        <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
    </button>

    {{-- Image Section --}}
    <div class="img-zoom-container bg-light" style="padding-top: 100%; position: relative;">
        <img src="{{ $product->image_url }}"
            class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
            alt="{{ $product->name }}">

        @if($product->has_discount)
        <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-danger px-3 py-2 fw-bold shadow-sm">
            -{{ $product->discount_percentage }}%
        </span>
        @endif
    </div>

    {{-- Info Section --}}
    <div class="card-body d-flex flex-column p-4">
        <span class="category-label mb-1">{{ $product->category->name }}</span>
        
        <h6 class="card-title mb-3">
            <a href="{{ route('catalog.show', $product->slug) }}" 
               class="text-decoration-none text-dark stretched-link fw-bold opacity-90 h-100 d-block">
                {{ Str::limit($product->name, 45) }}
            </a>
        </h6>

        <div class="mt-auto pt-2 border-top border-light">
            @if($product->has_discount)
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-black text-danger price-text mb-0">
                        {{ $product->formatted_price }}
                    </span>
                    <small class="text-decoration-line-through text-muted" style="font-size: 0.8rem;">
                        {{ $product->formatted_original_price }}
                    </small>
                </div>
            @else
                <p class="fw-black text-primary price-text mb-0">
                    {{ $product->formatted_price }}
                </p>
            @endif
        </div>
    </div>
</div>