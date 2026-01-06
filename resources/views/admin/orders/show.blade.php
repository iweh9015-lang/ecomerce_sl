@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-lg-8">
        {{-- List Item --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Item Pesanan</h5>
            </div>
            <div class="card-body">
                @foreach($order->items as $item)
                    <div class="d-flex mb-3">
                        <img src="{{ $item->product->image_url }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                            <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                        </div>
                        <div class="fw-bold">
                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fs-5 fw-bold">
                    <span>Total Pembayaran</span>
                    <span class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Info Customer --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Info Customer</h5>
            </div>
            <div class="card-body">
                <p class="mb-1 fw-bold">{{ $order->user->name }}</p>
                <p class="mb-1 text-muted">{{ $order->user->email }}</p>
            </div>
        </div>

        {{-- Action Card --}}
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Update Status Order</h6>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label small text-muted">Status Saat Ini: <strong>{{ ucfirst($order->status) }}</strong></label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Sedang Dikemas)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered (Sampai Tujuan)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batalkan & Restock)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Update Status
                    </button>
                </form>

                @if($order->status == 'cancelled')
                    <div class="alert alert-danger mt-3 mb-0 small">
                        <i class="bi bi-info-circle"></i> Pesanan ini telah dibatalkan. Stok produk telah dikembalikan otomatis.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection