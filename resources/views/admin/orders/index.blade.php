@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Pesanan</h4>
        <small class="text-muted">Kelola semua transaksi customer</small>
    </div>
</div>

<div class="card shadow-sm border-0">
    {{-- FILTER --}}
    <div class="card-header bg-white py-3 border-bottom">
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}"
                   href="{{ route('admin.orders.index') }}">
                    Semua
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                   href="{{ route('admin.orders.index', ['status' => 'pending']) }}">
                    ⏳ Pending
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}"
                   href="{{ route('admin.orders.index', ['status' => 'processing']) }}">
                    📦 Diproses
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                   href="{{ route('admin.orders.index', ['status' => 'completed']) }}">
                    ✅ Selesai
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}"
                   href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">
                    ❌ Dibatalkan
                </a>
            </li>
        </ul>
    </div>

    {{-- TABLE --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No. Order</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">
                                #{{ $order->order_number }}
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>

                            <td>
                                {{ $order->created_at->format('d M Y') }}
                                <br>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>

                            <td class="fw-bold">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-info text-dark">Diproses</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Selesai</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                        @break
                                @endswitch
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    👁 Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if($orders->hasPages())
        <div class="card-footer bg-white">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection