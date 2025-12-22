@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->primaryImage->url ?? '/img/no-image.png' }}" 
                 class="img-fluid rounded shadow" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">{{ $product->name }}</h2>
            <p class="text-muted">Kategori: {{ $product->category->name ?? '-' }}</p>
            <h4 class="text-success fw-bold mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </h4>
            <p>{{ $product->description }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-lg btn-primary">
                    🛒 Tambahkan ke Keranjang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
