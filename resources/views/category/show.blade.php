@extends('layouts.app') <!-- Pastikan menggunakan layout utama Anda -->

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Tampilkan informasi kategori -->
        <div class="mb-6">
            <h1 class="text-3xl font-semibold">{{ $category->name }}</h1>
            <p class="text-gray-600">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
        </div>

        <!-- Daftar produk dalam kategori ini -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="border rounded-lg p-4 bg-white shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4 rounded-md">
                    <h3 class="text-xl font-semibold">{{ $product->name }}</h3>
                    <p class="text-gray-500 mb-2">{{ $product->short_description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="{{ route('catalog.show', $product->slug) }}" class="text-blue-500 hover:underline">Lihat Produk</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
@endsection
