@props(['product'])

<div class="card h-100 border-0 shadow-sm product-card">
    {{-- Gambar --}}
    <div class="position-relative overflow-hidden bg-light" style="padding-top: 100%;">
        <img src="{{ $product->image_url }}"
            class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover">

        @if($product->has_discount)
        <span class="position-absolute top-0 start-0 m-2 badge bg-danger">
            -{{ $product->discount_percentage }}%
        </span>
        @endif
    </div>

    {{-- Info --}}
    <div class="card-body d-flex flex-column">
        <small class="text-muted mb-1">{{ $product->category->name }}</small>
        <h6 class="card-title mb-2">
            <a href="{{ route('catalog.show', $product->slug) }}" class="text-decoration-none text-dark stretched-link">
                {{ $product->name }}
            </a>
        </h6>

        <div class="mt-auto">
            @if($product->has_discount)
            <p class="fw-bold text-danger mb-0">{{ $product->formatted_price }}</p>
            <small class="text-decoration-line-through text-muted">{{ $product->formatted_original_price }}</small>
            @else
            <p class="fw-bold text-primary mb-0">{{ $product->formatted_price }}</p>
            @endif
            <button onclick="toggleWishlist({{ $product->id }})"
                class="wishlist-btn-{{ $product->id }} btn btn-light btn-sm rounded-circle p-2 transition">
                <i
                    class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' }} fs-5"></i>
            </button>
        </div>
    </div>
</div>