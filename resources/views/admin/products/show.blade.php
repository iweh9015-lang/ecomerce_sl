@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white p-8 rounded-xl border">

        <!-- IMAGE -->
        <div class="aspect-square bg-gray-100 flex items-center justify-center rounded-lg">
            <span class="text-gray-400">No Image</span>
        </div>

        <!-- INFO -->
        <div>
            <h1 class="text-3xl font-bold mb-4">
                {{ $product->name }}
            </h1>

            <p class="text-gray-600 mb-6">
                {{ $product->description }}
            </p>

            <div class="text-2xl font-bold text-blue-600 mb-6">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <div class="flex items-center gap-4">
                <button onclick="addToCart({{ $product->id }})"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Masukkan Keranjang
                </button>

                <a href="{{ route('cart.index') }}"
                   class="border px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                    Lihat Keranjang
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
