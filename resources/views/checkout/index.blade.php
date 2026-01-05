@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-4">

    <h1 class="mb-4 fw-bold">Checkout</h1>

    {{-- CART EMPTY --}}
    @if($cartItems->isEmpty())
        <div class="alert alert-warning">
            Keranjang belanja kamu masih kosong.
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">
            Kembali Belanja
        </a>
    @else

    <div class="row">
        {{-- LEFT: SHIPPING / USER INFO --}}
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header fw-semibold">
                    Informasi Pengiriman
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p class="mb-0 text-muted">
                        Alamat pengiriman akan diatur di tahap selanjutnya.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: ORDER SUMMARY --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-header fw-semibold">
                    Ringkasan Pesanan
                </div>
                <div class="card-body">
                    <ul class="list-group mb-3">
                        @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    {{ $item->product->name }}
                                    <small class="text-muted d-block">
                                        Qty: {{ $item->quantity }}
                                    </small>
                                </div>
                                <span>
                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold mb-3">
                        <span>Total</span>
                        <span>
                            Rp {{ number_format($totalPrice, 0, ',', '.') }}
                        </span>
                    </div>

                    <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                             Proses Checkout
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@endsection
