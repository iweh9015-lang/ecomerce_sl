@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Wishlist Saya</h1>

            @if ($items->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($items as $wishlist)
                        <div class="border border-gray-200 rounded overflow-hidden hover:shadow-lg transition">
                            <!-- Product Image -->
                            <div class="relative w-full h-48 bg-gray-200 overflow-hidden">
                                <img src="{{ $wishlist->product->primaryImage->image_url ?? asset('images/placeholder.svg') }}"
                                     alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover">

                                <!-- Love Button -->
                                <button onclick="toggleWishlist({{ $wishlist->product->id }})"
                                        class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow hover:bg-red-50 transition">
                                    <i id="wishlist-icon-{{ $wishlist->product->id }}" class="fas fa-heart text-red-600"></i>
                                </button>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <a href="{{ route('catalog.show', $wishlist->product->slug) }}"
                                   class="block text-lg font-bold text-gray-900 hover:text-blue-600 mb-2">
                                    {{ $wishlist->product->name }}
                                </a>

                                <p class="text-gray-600 text-sm mb-3">
                                    {{ $wishlist->product->category->name }}
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-gray-900">
                                        Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}
                                    </span>

                                    @if ($wishlist->product->discount)
                                        <span class="text-sm font-bold text-white bg-red-600 px-2 py-1 rounded">
                                            -{{ $wishlist->product->discount }}%
                                        </span>
                                    @endif
                                </div>

                                <button onclick="addToCart({{ $wishlist->product->id }})"
                                        class="w-full px-4 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Wishlist Kosong</h2>
                    <p class="text-gray-600 mb-6">Belum ada produk favorit Anda</p>
                    <a href="{{ route('catalog.index') }}"
                       class="inline-block px-8 py-3 bg-blue-600 text-white font-bold rounded hover:bg-blue-700 transition">
                        Jelajahi Produk
                    </a>
                </div>
            @endif
        </div>
    </section>

    <script>
        // Toggle Wishlist
        async function toggleWishlist(productId) {
            const heartIcon = document.getElementById(`wishlist-icon-${productId}`);
            
            try {
                let response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                let data = await response.json();

                if (data.success) {
                    // Change heart icon style based on added/removed from wishlist
                    if (data.added) {
                        heartIcon.classList.add('text-red-600');
                        heartIcon.classList.remove('text-gray-300');
                    } else {
                        heartIcon.classList.add('text-gray-300');
                        heartIcon.classList.remove('text-red-600');
                    }
                    alert(data.message); // Optionally show a success message
                    location.reload(); // Reload to update the page status
                }
            } catch (error) {
                console.error("Error toggling wishlist:", error);
            }
        }

        // Add to Cart
        async function addToCart(productId) {
            try {
                let response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });
                let data = await response.json();

                if (data.success) {
                    alert(data.message); // Show a success message
                }
            } catch (error) {
                console.error("Error adding to cart:", error);
            }
        }
    </script>
@endsection
