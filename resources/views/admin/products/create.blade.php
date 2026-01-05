{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 fw-bold text-primary">
                <i class="bi bi-box-seam me-1"></i> Tambah Produk Baru
            </h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ================= BASIC INFO ================= --}}
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Informasi Produk
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                            required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : ''
                                }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi Produk</label>
                        <textarea name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Deskripsi singkat produk...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ================= PRICE & STOCK ================= --}}
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-cash-stack me-1"></i> Harga & Stok
                    </h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}" min="1000" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Harga Diskon (Opsional)</label>
                            <input type="number" name="discount_price"
                                class="form-control @error('discount_price') is-invalid @enderror"
                                value="{{ old('discount_price') }}" min="0">
                            @error('discount_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock') }}" min="0" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4 col-md-4">
                        <label class="form-label fw-semibold">Berat (gram)</label>
                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror"
                            value="{{ old('weight') }}" min="1" required>
                        @error('weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ================= IMAGES ================= --}}
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-images me-1"></i> Gambar Produk
                    </h6>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Gambar</label>
                        <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror"
                            multiple>
                        <small class="text-muted">
                            Maksimal 10 gambar. JPG, PNG, WEBP. Maks 2MB per file.
                        </small>
                        @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('images.*') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    {{-- ================= STATUS ================= --}}
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-toggle-on me-1"></i> Status Produk
                    </h6>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{
                                    old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Aktif</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{
                                    old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold">Produk Unggulan</label>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-1"></i> Simpan Produk
                        </button>
                    </div>

                </form>

            </div>
        </div>
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