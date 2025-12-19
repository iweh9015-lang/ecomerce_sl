@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">➕ Tambah Produk</h1>

        <a href="{{ route('admin.products.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
            ⬅ Kembali
        </a>
    </div>

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow rounded-xl p-6 space-y-6">
        @csrf

        {{-- Nama Produk --}}
        <div>
            <label class="block font-medium mb-2">Nama Produk</label>
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                   placeholder="Masukkan nama produk" required>
        </div>

        {{-- Harga --}}
        <div>
            <label class="block font-medium mb-2">Harga</label>
            <input type="number" name="price"
                   value="{{ old('price') }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                   placeholder="Masukkan harga" required>
        </div>

        {{-- Stok --}}
        <div>
            <label class="block font-medium mb-2">Stok</label>
            <input type="number" name="stock"
                   value="{{ old('stock') }}"
                   class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                   placeholder="Jumlah stok" required>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block font-medium mb-2">Deskripsi</label>
            <textarea name="description" rows="4"
                      class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200"
                      placeholder="Deskripsi produk">{{ old('description') }}</textarea>
        </div>

        {{-- Gambar --}}
        <div>
            <label class="block font-medium mb-2">Gambar Produk</label>
            <input type="file" name="image"
                   class="w-full border rounded-lg px-4 py-2">
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3">
            <button type="reset"
                    class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                Reset
            </button>

            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Simpan Produk
            </button>
        </div>

    </form>
</div>
@endsection
