@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-6">Katalog Produk</h1>

    <!-- FILTER -->
    <form method="GET" class="grid md:grid-cols-3 gap-4 mb-8">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari produk..."
               class="border rounded px-3 py-2">

        <select name="category" class="border rounded px-3 py-2">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white rounded px-4 py-2">
            Filter
        </button>
    </form>

    <!-- GRID PRODUK -->
    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($products as $product)
               <a href="{{ route('product.show', $product) }}"
   class="block bg-white border rounded-xl shadow-sm p-4 hover:shadow-md transition">


                    <!-- IMAGE -->
                    <div class="h-40 bg-gray-100 rounded mb-3 flex items-center justify-center">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 class="object-cover h-full w-full rounded">
                        @else
                            <span class="text-gray-400 text-sm">No Image</span>
                        @endif
                    </div>

                    <h3 class="font-semibold text-lg">
                        {{ $product->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mb-1">
                        {{ $product->category->name ?? '-' }}
                    </p>

                    <div class="font-bold text-blue-600 mb-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <p class="text-sm text-gray-500">
                        Stok: {{ $product->stock }}
                    </p>
                </a>
            @endforeach
        </div>

        <!-- PAGINATION -->
        <div class="mt-10">
            {{ $products->links('pagination::tailwind') }}
        </div>
    @else
        <div class="text-center text-gray-500 py-10">
            Produk tidak tersedia
        </div>
    @endif

</div>
@endsection
