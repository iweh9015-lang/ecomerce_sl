@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-10">

    <!-- BREADCRUMB -->
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('beranda') }}" class="hover:underline">Beranda</a> /
        <a href="{{ route('catalog.index') }}" class="hover:underline">Katalog</a> /
        <span class="text-gray-700">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- IMAGE -->
        <div class="bg-white border rounded-xl p-4">
            @if ($product->image)
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="w-full h-96 object-cover rounded-lg"
                    alt="{{ $product->name }}"
                >
            @else
                <div class="h-96 flex items-center justify-center text-gray-400">
                    No Image
                </div>
            @endif
        </div>

        <!-- INFO -->
        <div>
            <h1 class="text-3xl font-bold mb-2">
                {{ $product->name }}
            </h1>

            <p class="text-gray-500 mb-4">
                Kategori:
                <span class="font-medium">
                    {{ $product->category->name ?? '-' }}
                </span>
            </p>

            <!-- PRICE -->
            <div class="text-2xl font-bold text-blue-600 mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            <!-- STOCK -->
            <p class="mb-4">
                Stok:
                @if ($product->stock > 0)
                    <span class="text-green-600 font-semibold">
                        {{ $product->stock }} tersedia
                    </span>
                @else
                    <span class="text-red-600 font-semibold">
                        Habis
                    </span>
                @endif
            </p>

            <!-- ADD TO CART -->
            @if ($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                        + Tambah ke Keranjang
                    </button>
                </form>
            @endif

            <!-- WISHLIST -->
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                @csrf
                <button
                    class="text-sm text-gray-600 hover:text-red-500 transition">
                    ❤️ Tambah ke Wishlist
                </button>
            </form>
        </div>
    </div>

    <!-- DESCRIPTION -->
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-3">
            Deskripsi Produk
        </h2>

        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

</div>
@endsection
