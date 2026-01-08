{{-- resources/views/cart/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
    body { background-color: #f8fafc; }

    .cart-card {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        border: none;
        padding: 1.25rem;
    }

    .product-name {
        font-weight: 700;
        color: #1e293b;
        transition: color 0.2s;
    }

    .product-name:hover { color: #2563eb; }

    /* Custom Input Number */
    .quantity-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.3rem;
        max-width: 90px;
        font-weight: 600;
    }

    .quantity-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .summary-box {
        border: none;
        border-radius: 1.5rem;
        background: #ffffff;
        position: sticky;
        top: 100px;
    }

    .btn-checkout-primary {
        background: #2563eb;
        border: none;
        padding: 0.8rem;
        border-radius: 1rem;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-checkout-primary:hover {
        background: #1e40af;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    }

    .empty-cart-icon {
        width: 150px;
        height: 150px;
        background: #eff6ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 2rem;
        font-size: 4rem;
    }
</style>

<div class="container py-5">
    <div class="d-flex align-items-center mb-4 animate__animated animate__fadeIn">
        <div class="bg-primary text-white rounded-3 p-2 me-3">
            <i class="bi bi-cart3 fs-4"></i>
        </div>
        <h2 class="fw-black text-dark mb-0">Keranjang Belanja</h2>
    </div>

    @if($cart && $cart->items->count())
    <div class="row g-4">
        {{-- List Barang --}}
        <div class="col-lg-8 animate__animated animate__fadeInLeft">
            <div class="card cart-card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center" style="width: 150px;">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                            <tr>
                                <td class="py-4 px-3">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative">
                                            <img src="{{ $item->product->image_url }}" class="rounded-4 shadow-sm me-3" width="80" height="80" style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <a href="{{ route('catalog.show', $item->product->slug) }}" class="text-decoration-none product-name d-block mb-1">
                                                {{ Str::limit($item->product->name, 35) }}
                                            </a>
                                            <span class="badge bg-light text-primary rounded-pill fw-medium">
                                                {{ $item->product->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-medium text-muted">
                                    Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            max="{{ $item->product->stock }}"
                                            class="form-control quantity-control mx-auto text-center"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="text-end fw-bold text-dark px-3">
                                    Rp{{ number_format($item->subtotal ?? $item->total_price, 0, ',', '.') }}
                                </td>
                                <td class="text-center px-3">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus item ini?')">
                                            <i class="bi bi-x-circle-fill fs-5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3 px-4">
                    <p class="mb-0 text-muted small"><i class="bi bi-info-circle me-1"></i> Perubahan jumlah barang akan otomatis memperbarui total belanja.</p>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="col-lg-4 animate__animated animate__fadeInRight">
            <div class="card summary-box shadow-lg">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                        <span class="fw-medium text-dark">Rp{{ number_format($cart->items->sum(fn($item) => $item->subtotal), 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Diskon Toko</span>
                        <span class="text-success fw-medium">-Rp0</span>
                    </div>

                    <hr class="my-4" style="border-top: 2px dashed #e2e8f0;">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h6 fw-bold mb-0">Total Bayar</span>
                        <span class="h4 fw-black text-primary mb-0">
                            Rp{{ number_format($cart->items->sum(fn($item) => $item->subtotal), 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-checkout-primary w-100 mb-3">
                        Lanjut ke Checkout <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    
                    <a href="{{ route('catalog.index') }}" class="btn btn-light w-100 rounded-4 fw-bold text-muted border-0">
                        Tambah Barang Lagi
                    </a>
                </div>
            </div>
            
            {{-- Badge Keamanan --}}
            <div class="mt-4 text-center">
                <div class="d-flex justify-content-center gap-3">
                    <i class="bi bi-shield-lock text-muted fs-4"></i>
                    <i class="bi bi-patch-check text-muted fs-4"></i>
                    <i class="bi bi-truck text-muted fs-4"></i>
                </div>
                <p class="smaller text-muted mt-2">Belanja aman dengan garansi pengembalian 7 hari.</p>
            </div>
        </div>
    </div>
    @else
    {{-- Empty State --}}
    <div class="text-center py-5 animate__animated animate__zoomIn">
        <div class="empty-cart-icon">
            <i class="bi bi-cart-x"></i>
        </div>
        <h2 class="fw-black text-dark">Keranjangmu Masih Sepi</h2>
        <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
            Sepertinya kamu belum menambahkan barang apapun. Yuk, intip koleksi terbaru kami!
        </p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-lg">
            Mulai Cari Produk
        </a>
    </div>
    @endif
</div>
@endsection