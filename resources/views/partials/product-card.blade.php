<div class="bg-white rounded-xl border shadow-sm hover:shadow-lg transition overflow-hidden">
    <div class="aspect-square bg-gray-100 flex items-center justify-center">
        <span class="text-gray-400 text-sm">No Image</span>
    </div>

    <div class="p-4">
        <h3 class="font-semibold text-lg line-clamp-2">
            {{ $product->name }}
        </h3>

        <p class="text-sm text-gray-500 mt-1 line-clamp-2">
            {{ $product->description }}
        </p>

        <div class="mt-3 font-bold text-blue-600">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        {{-- BUTTON ADD TO CART --}}
       <button onclick="toggleWishlist({{ $product->id }})"
        class="wishlist-btn-{{ $product->id }} btn btn-light btn-sm rounded-circle p-2 transition">
    <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary' }} fs-5"></i>
</button>
    </div>
</div>
