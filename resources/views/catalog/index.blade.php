@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')

<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a> /
            <span class="text-gray-800 font-semibold">Katalog Produk</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- FILTER -->
        <aside class="lg:sticky lg:top-24">
            <div class="bg-white rounded-xl border p-6">
                <h3 class="font-bold mb-4">Filter Produk</h3>

                <form method="GET" class="space-y-4">
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Cari produk..."
                           class="w-full px-4 py-2 border rounded-lg">

                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
                        Terapkan
                    </button>
                </form>
            </div>
        </aside>

        <!-- PRODUK -->
        <main class="lg:col-span-3">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">
                    {{ $products->total() }} Produk
                </h1>

                <form method="GET">
                    <select name="sort" onchange="this.form.submit()"
                            class="border px-3 py-2 rounded-lg text-sm">
                        <option value="newest">Terbaru</option>
                        <option value="price_asc">Harga Termurah</option>
                        <option value="price_desc">Harga Termahal</option>
                    </select>
                </form>
            </div>

            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <h3 class="text-xl font-bold">Produk tidak ditemukan</h3>
                </div>
            @endif
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
    @csrf
    <button
        type="submit"
        class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
        Masukkan Keranjang
    </button>
</form>

        </main>
    </div>
</div>

@endsection
