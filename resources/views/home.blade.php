@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- ===================================================== -->
<!-- HERO -->
<!-- ===================================================== -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-blue-800 text-white">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top,white,transparent)]"></div>

    <div class="relative max-w-7xl mx-auto px-4 py-24 text-center">
        <span class="inline-block mb-4 px-4 py-1 rounded-full bg-white/20 text-sm font-semibold">
            🛍️ Marketplace Terpercaya
        </span>

        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            Selamat Datang di <br>
            <span class="text-blue-200">TokoIqbaal</span>
        </h1>

        <p class="max-w-2xl mx-auto text-lg text-blue-100 mb-10">
            Temukan ribuan produk berkualitas dengan harga terbaik dan pengiriman cepat ke seluruh Indonesia.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('catalog.index') }}"
               class="px-8 py-3 rounded-xl font-semibold bg-white text-blue-700 hover:bg-blue-100 transition shadow-lg">
                Belanja Sekarang
            </a>
        </div>
    </div>
</section>

<!-- ===================================================== -->
<!-- KATEGORI POPULER -->
<!-- ===================================================== -->
<section id="kategori" class="max-w-7xl mx-auto px-4 py-20">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-extrabold mb-3">Kategori Populer</h2>
        <p class="text-slate-500">Pilih kategori favoritmu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}"
               class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition border hover:-translate-y-1">

                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center mb-6">
                    <span class="text-blue-600 font-bold text-xl">
                        {{ substr($category->name, 0, 1) }}
                    </span>
                </div>

                <h3 class="text-xl font-bold mb-2">{{ $category->name }}</h3>

                <p class="text-slate-500 text-sm mb-4">
                    {{ $category->active_products_count }} produk tersedia
                </p>

                <span class="text-blue-600 font-semibold text-sm">
                    Lihat Produk →
                </span>
            </a>
        @endforeach
    </div>
</section>

<!-- ===================================================== -->
<!-- PRODUK UNGGULAN -->
<!-- ===================================================== -->
<section class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold mb-10 text-center">
            Produk Unggulan
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($featuredProducts as $product)
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

                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                Masukkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================================================== -->
<!-- PRODUK TERBARU -->
<!-- ===================================================== -->
<section class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-2xl font-bold mb-6">Produk Terbaru</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach ($latestProducts as $product)
            <div class="bg-white rounded-xl border shadow-sm p-4">

                <h3 class="font-semibold text-lg">
                    {{ $product->name }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ \Illuminate\Support\Str::limit($product->description, 60) }}
                </p>

                <div class="mt-2 font-bold text-blue-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Masukkan Keranjang
                    </button>
                </form>

            </div>
        @endforeach
    </div>
</section>

@endsection
