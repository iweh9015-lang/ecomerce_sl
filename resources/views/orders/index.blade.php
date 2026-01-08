{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    .order-card {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    .order-card:hover {
        border-color: #3498db;
        transform: translateY(-2px);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
    }
    /* Warna Status Custom */
    .bg-pending { background-color: #fff9db; color: #f08c00; }
    .bg-processing { background-color: #e7f5ff; color: #1971c2; }
    .bg-shipped { background-color: #e3faf3; color: #0ca678; }
    .bg-delivered { background-color: #ebfbee; color: #2f9e44; }
    .bg-cancelled { background-color: #fff5f5; color: #e03131; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Riwayat Pesanan</h1>
                    <p class="text-muted small">Pantau status pengiriman dan detail belanja Anda.</p>
                </div>
                <i class="bi bi-bag-check fs-1 text-primary opacity-25"></i>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-muted small">NOMOR ORDER</th>
                                    <th class="border-0 text-muted small">TANGGAL</th>
                                    <th class="border-0 text-muted small">STATUS</th>
                                    <th class="border-0 text-muted small">TOTAL</th>
                                    <th class="text-end pe-4 border-0 text-muted small">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <div class="text-dark">{{ $order->created_at->translatedFormat('d M Y') }}</div>
                                        <small class="text-muted" style="font-size: 0.7rem;">{{ $order->created_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'pending'    => ['label' => 'Menunggu', 'class' => 'bg-pending'],
                                                'processing' => ['label' => 'Diproses', 'class' => 'bg-processing'],
                                                'shipped'    => ['label' => 'Dikirim', 'class' => 'bg-shipped'],
                                                'delivered'  => ['label' => 'Selesai', 'class' => 'bg-delivered'],
                                                'cancelled'  => ['label' => 'Dibatalkan', 'class' => 'bg-cancelled'],
                                            ];
                                            $currentStatus = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'bg-secondary text-white'];
                                        @endphp
                                        <span class="status-badge {{ $currentStatus['class'] }}">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                            Detail Pesanan
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-basket3 fs-1 text-muted opacity-25 mb-3 d-block"></i>
                                            <h5 class="fw-bold text-muted">Belum ada pesanan</h5>
                                            <p class="text-muted small">Sepertinya Anda belum pernah berbelanja di sini.</p>
                                            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4 mt-2">Mulai Belanja</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($orders->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection