@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">🛍️ Katalog Produk</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $product->primaryImage->url ?? '/img/no-image.png' }}" 
                         class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text fw-bold text-success">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <a href="{{ route('catalog.show', $product->slug) }}" 
                           class="btn btn-outline-primary mb-2">Detail Produk</a>
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100">
                                + Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
