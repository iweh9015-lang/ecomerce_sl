@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 fw-bold text-info">
                <i class="bi bi-eye me-1"></i> Detail Produk
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning text-white">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">

            {{-- ================= IMAGES ================= --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">

                        {{-- Primary Image --}}
                        <img src="{{ asset('storage/'.$product->primaryImage?->image_path) }}"
                            class="img-fluid rounded mb-3 w-100" style="object-fit:cover;max-height:320px">

                        {{-- Gallery --}}
                        <div class="row g-2">
                            @foreach($product->images as $image)
                            <div class="col-4">
                                <img src="{{ asset('storage/'.$image->image_path) }}" class="img-fluid rounded border"
                                    style="object-fit:cover;height:90px;width:100%">
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            {{-- ================= PRODUCT INFO ================= --}}
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-1">
                            {{ $product->name }}
                        </h4>

                        <p class="text-muted mb-2">
                            <i class="bi bi-tags me-1"></i>
                            {{ $product->category->name }}
                        </p>

                        {{-- Price --}}
                        <h5 class="text-primary fw-bold mb-3">
                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            @if($product->discount_price)
                            <span class="text-muted fs-6 text-decoration-line-through ms-2">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @endif
                        </h5>

                        {{-- Status --}}
                        <div class="mb-3 d-flex gap-2">
                            <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>

                            @if($product->is_featured)
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-star-fill me-1"></i> Unggulan
                            </span>
                            @endif
                        </div>

                        <hr>

                        {{-- Description --}}
                        <p class="mb-4">
                            {!! $product->description ?: '-' !!}
                        </p>

                        {{-- Meta --}}
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <strong>Stok</strong>
                                <div>{{ $product->stock }}</div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <strong>Berat</strong>
                                <div>{{ $product->weight }} gram</div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <strong>Dibuat</strong>
                                <div>{{ $product->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection