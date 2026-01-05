@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 fw-bold text-warning">
                <i class="bi bi-pencil-square me-1"></i> Edit Produk
            </h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ================= BASIC INFO ================= --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Informasi Produk
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                            required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) ==
                                $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi Produk</label>
                        <textarea name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- ================= PRICE & STOCK ================= --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-cash-stack me-1"></i> Harga & Stok
                    </h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $product->price) }}" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Harga Diskon</label>
                            <input type="number" name="discount_price"
                                class="form-control @error('discount_price') is-invalid @enderror"
                                value="{{ old('discount_price', $product->discount_price) }}">
                            @error('discount_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $product->stock) }}" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Berat (gram)</label>
                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror"
                            value="{{ old('weight', $product->weight) }}" required>
                        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- ================= IMAGES ================= --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-images me-1"></i> Gambar Produk
                    </h6>

                    {{-- Upload baru --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tambah Gambar Baru</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <small class="text-muted">Upload untuk menambah gambar baru</small>
                    </div>

                    {{-- Gambar lama --}}
                    <div class="row g-3">
                        @foreach($product->images as $image)
                        <div class="col-md-3">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('storage/'.$image->image_path) }}" class="card-img-top"
                                    style="object-fit:cover;height:160px">

                                <div class="card-body p-2 text-center">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="primary_image"
                                            value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }}>
                                        <label class="form-check-label small">
                                            Gambar Utama
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delete_images[]"
                                            value="{{ $image->id }}">
                                        <label class="form-check-label small text-danger">
                                            Hapus
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- ================= STATUS ================= --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-toggle-on me-1"></i> Status Produk
                    </h6>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{
                                    old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Aktif</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{
                                    old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Produk Unggulan</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="d-grid mb-5">
                <button type="submit" class="btn btn-warning btn-lg text-white">
                    <i class="bi bi-save me-1"></i> Update Produk
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
@push('scripts')
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/ctgoj8efdfr1i2jqusoi0hyy1luhjn7lk7r8rnmmhe2f6r35/tinymce/8/tinymce.min.js"
    referrerpolicy="origin" crossorigin="anonymous"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
@endpush