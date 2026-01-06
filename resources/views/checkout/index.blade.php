@extends('layouts.app')
@section('content')

<div class="container max-w-7xl mx-auto px-4 py-8">
    <h1 class="h2 mb-5 fw-bold">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="row g-5">
            <!-- Form Informasi Pengiriman -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 card-title mb-4">Informasi Pengiriman</h2>

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label">Nama Penerima</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ auth()->user()->name }}" required>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea name="address" id="address" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 1.5rem;">
                    <div class="card-body">
                        <h2 class="h5 card-title mb-4">Ringkasan Pesanan</h2>

                        <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($cart->items as $item)
                            <div class="d-flex justify-content-between mb-2 small text-muted">
                                <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                                <span class="fw-medium text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.')
                                    }}</span>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h6 mb-0">Total</span>
                            <span class="h6 mb-0 fw-bold">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',',
                                '.') }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection