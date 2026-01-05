@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Detail Pesanan</h4>
        <small class="text-muted">Order #{{ $order->order_number }}</small>
    </div>

    <span class="badge px-3 py-2
        @if($order->status == 'pending') bg-warning
        @elseif($order->status == 'processing') bg-info
        @elseif($order->status == 'completed') bg-success
        @else bg-danger
        @endif
    ">
        {{ strtoupper($order->status) }}
    </span>
</div>

<div class="row">
    {{-- LEFT CONTENT --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold">📦 Item Pesanan</h6>
            </div>

            <div class="card-body">
                @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <img src="{{ $item->product->image_url }}"
                             class="rounded me-3"
                             style="width:70px;height:70px;object-fit:cover">

                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                            <small class="text-muted">
                                {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}
                            </small>
                        </div>

                        <div class="fw-bold text-end">
                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <span class="fw-bold fs-5">Total Pembayaran</span>
                    <span class="fw-bold fs-4 text-primary">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="col-lg-4">
        {{-- CUSTOMER INFO --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold">👤 Info Customer</h6>
            </div>
            <div class="card-body">
                <p class="fw-bold mb-1">{{ $order->user->name }}</p>
                <p class="text-muted mb-1">{{ $order->user->email }}</p>
                <small class="text-muted">User ID: {{ $order->user->id }}</small>
            </div>
        </div>

        {{-- ORDER ACTION --}}
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">⚙️ Update Status Pesanan</h6>

                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label small text-muted">
                            Status Saat Ini:
                            <strong>{{ ucfirst($order->status) }}</strong>
                        </label>

                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                Processing (Dikemas)
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                Completed (Selesai)
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                Cancelled (Batalkan)
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        💾 Simpan Perubahan
                    </button>
                </form>

                @if($order->status == 'cancelled')
                    <div class="alert alert-danger mt-3 mb-0 small">
                        <i class="bi bi-exclamation-triangle"></i>
                        Pesanan dibatalkan. Stok produk telah dikembalikan otomatis.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
