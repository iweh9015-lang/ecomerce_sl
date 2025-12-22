{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Produk --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Kategori Dropdown --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                         @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Harga & Stok --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Gambar</label>
                        <input type="file" name="images[]" multiple class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection