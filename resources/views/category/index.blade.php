{{-- ================================================
     FILE: resources/views/categories/index.blade.php
     FUNGSI: Menampilkan daftar kategori
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-blue-600 text-white py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-3xl lg:text-5xl font-extrabold leading-tight mb-4 animate__animated animate__fadeIn">
                    Kategori Produk
                </h1>
                <p class="text-lg mb-8 text-blue-100 opacity-90 animate__animated animate__fadeIn animate__delay-1s">
                    Temukan berbagai kategori produk yang tersedia di toko kami.
                </p>
            </div>
        </div>
    </section>

    {{-- Kategori Section --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-12 text-center">
                Daftar Kategori
            </h2>

            {{-- Category Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category->id) }}"
                        class="group p-6 bg-gray-50 border border-gray-200 rounded-lg hover:shadow-xl transition duration-300 transform hover:scale-105"
                        aria-label="Lihat kategori {{ $category->name }}">
                        <div class="h-48 bg-gray-100 rounded-md mb-4 group-hover:bg-blue-50 transition-all">
                            {{-- Menambahkan gambar kategori, jika ada --}}
                            <img src="{{ $category->image_url ?? asset('images/default-category.jpg') }}" 
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover rounded-md group-hover:opacity-75 transition-all duration-300">
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600">{{ $category->products_count }} produk</p>
                    </a>
                @endforeach
            </div>

            {{-- Paginasi --}}
            <div class="mt-12 text-center">
                {{ $categories->links() }} <!-- Menampilkan paginasi -->
            </div>
        </div>
    </section>
@endsection
