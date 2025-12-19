@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    <h1 class="text-2xl font-bold mb-6">✏️ Edit Produk</h1>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.products.update', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white shadow rounded-xl p-6 space-y-5">

        @csrf
        @method('PUT')

        {{-- NAMA --}}
        <div>
            <label class="block font-semibold mb-1">Nama Produk</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $product->name) }}"
                class="w-full border rounded px-4 py-2 focus:ring focus:ring-blue-300"
                required>
        </div>

        {{-- HARGA --}}
        <div>
            <label class="block font-semibold mb-1">Harga</label>
            <input
                type="number"
                name="price"
                value="{{ old('price', $product->price) }}"
                class="w-full border rounded px-4 py-2"
                required>
        </div>

        {{-- STOK --}}
        <div>
            <label class="block font-semibold mb-1">Stok</label>
            <input
                type="number"
                name="stock"
                value="{{ old('stock', $product->stock) }}"
                class="w-full border rounded px-4 py-2"
                required>
        </div>

        {{-- DESKRIPSI --}}
        <div>
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea
                name="description"
                rows="4"
                class="w-full border rounded px-4 py-2">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- GAMBAR --}}
        <div>
            <label class="block font-semibold mb-1">Gambar Produk</label>

            @if ($product->image)
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="w-32 h-32 object-cover rounded mb-3">
            @endif

            <input
                type="file"
                name="image"
                class="w-full border rounded px-4 py-2">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-between items-center pt-4">
            <a
                href="{{ route('admin.products.index') }}"
                class="text-gray-600 hover:underline">
                ← Kembali
            </a>

            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                💾 Update Produk
            </button>
        </div>
    </form>
</div>
@endsection
