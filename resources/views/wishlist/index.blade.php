{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="container py-5">
    <h1 class="h3 fw-bold mb-4">Wishlist Saya</h1>

    @if($products->count())
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($products as $product)
                <div class="col">
                     <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5 bg-light rounded-3 shadow-sm">
            <div class="mb-3">
                <i class="bi bi-heart text-secondary" style="font-size: 4rem;"></i>
            </div>
            <h3 class="h5 fw-medium text-dark">Wishlist Kosong</h3>
            <p class="text-muted mt-1">Simpan produk yang kamu suka di sini.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary mt-3 px-4">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection