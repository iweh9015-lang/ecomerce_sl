{{-- resources/views/admin/orders/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<style>
    /* Status Badge Soft Styling */
    .badge-status {
        padding: 0.5rem 0.85rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .status-pending { background: #fff9db; color: #f08c00; }
    .status-processing { background: #e7f5ff; color: #1971c2; }
    .status-completed { background: #ebfbee; color: #2f9e44; }
    .status-cancelled { background: #fff5f5; color: #e03131; }

    .order-id {
        font-family: 'Monaco', 'Consolas', monospace;
        letter-spacing: -0.5px;
    }

    .nav-pills .nav-link {
        color: #64748b;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .nav-pills .nav-link.active {
        background-color: #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }
</style>

<div class="container-fluid py-4">
    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manajemen Pesanan</h3>
            <p class="text-muted mb-0">Monitor dan kelola status transaksi masuk secara real-time.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm bg-white shadow-sm">
                <i class="bi bi-download me-1"></i> Export Data
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- FILTER NAV --}}
        <div class="card-header bg-white py-3 border-bottom border-light">
            <ul class="nav nav-pills small">
                @php
                    $statuses = [
                        null => 'Semua Pesanan',
                        'pending' => '⏳ Menunggu',
                        'processing' => '📦 Diproses',
                        'completed' => '✅ Selesai',
                        'cancelled' => '❌ Dibatalkan'
                    ];
                @endphp
                @foreach($statuses as $key => $label)
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == $key ? 'active' : '' }}" 
                           href="{{ route('admin.orders.index', $key ? ['status' => $key] : []) }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- TABLE --}}
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="ps-4 py-3">NO. ORDER</th>
                            <th>PELANGGAN</th>
                            <th>WAKTU TRANSAKSI</th>
                            <th>TOTAL BAYAR</th>
                            <th>STATUS</th>
                            <th class="text-end pe-4">OPSI</th>
                        </tr>
                    </thead>

                    <tbody class="border-top-0">
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <span class="order-id fw-bold text-dark">#{{ $order->order_number }}</span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <span class="small fw-bold">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark small">{{ $order->user->name }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="small">
                                    <span class="text-dark">{{ $order->created_at->translatedFormat('d F Y') }}</span>
                                    <div class="text-muted" style="font-size: 0.7rem;">Pukul {{ $order->created_at->format('H:i') }} WIB</div>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                    <small class="text-muted small" style="font-size: 0.7rem;">Metode: Transfer Bank</small>
                                </td>

                                <td>
                                    @php
                                        $statusClass = [
                                            'pending' => 'status-pending',
                                            'processing' => 'status-processing',
                                            'completed' => 'status-completed',
                                            'cancelled' => 'status-cancelled',
                                        ][$order->status] ?? 'status-pending';

                                        $statusLabel = [
                                            'pending' => 'Pending',
                                            'processing' => 'Diproses',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Batal',
                                        ][$order->status] ?? 'Pending';
                                    @endphp
                                    <span class="badge-status {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-light border rounded-pill px-3 fw-bold small">
                                        Lihat Rincian
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-cart-x fs-1 text-light-emphasis mb-3 d-block"></i>
                                        <h5 class="text-muted">Tidak ada pesanan ditemukan</h5>
                                        <p class="text-muted small">Coba ubah filter status Anda atau periksa kembali nanti.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($orders->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</span>
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection