@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- 1. Stats Cards Grid --}}
    <div class="row g-4 mb-4">
        {{-- Revenue Card --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.8rem">Total Pendapatan</p>
                            <h4 class="fw-bold mb-0 text-success">
                                Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                            </h4>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-wallet2 text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Action Card --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-warning h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.8rem">Perlu Diproses</p>
                            <h4 class="fw-bold mb-0 text-warning">
                                {{ $stats['pending_orders'] ?? 0 }}
                            </h4>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-box-seam text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock Card --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-danger h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.8rem">Stok Menipis</p>
                            <h4 class="fw-bold mb-0 text-danger">
                                {{ $stats['low_stock'] ?? 0 }}
                            </h4>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-exclamation-triangle text-danger fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.8rem">Total Produk</p>
                            <h4 class="fw-bold mb-0 text-primary">
                                {{ $stats['total_products'] ?? 0 }}
                            </h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-tags text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- 2. Revenue Chart --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Grafik Penjualan (7 Hari)</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Recent Orders --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recentOrders as $order)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                <div>
                                    <div class="fw-bold text-primary">#{{ $order->order_number }}</div>
                                    <small class="text-muted">{{ $order->user->name ?? 'Guest' }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                    <span class="badge rounded-pill {{ $order->payment_status == 'paid' ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">Belum ada pesanan.</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none fw-bold small">
                        Lihat Semua Pesanan &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. Top Selling Products / New Products --}}
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Produk Terlaris & Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @forelse($topProducts as $product)
                    <div class="col-6 col-md-2">
                        <div class="text-center h-100 p-2 border rounded-3 hover-shadow transition">
                            {{-- Gunakan accessor image_url dari Model Product --}}
                            <img src="{{ $product->image_url }}" 
                                 class="rounded mb-2 w-100" 
                                 style="height: 120px; object-fit: cover;"
                                 onerror="this.src='https://placehold.co/300x300?text=No+Image'">
                            
                            <h6 class="text-truncate mb-1" style="font-size: 0.85rem" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h6>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-primary small">{{ $product->formatted_price }}</span>
                                <span class="badge bg-light text-dark border mt-1" style="font-size: 0.7rem">
                                    {{ $product->sold ?? 0 }} Terjual
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 text-muted">
                        Tidak ada produk untuk ditampilkan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Script Chart.js --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const labels = {!! json_encode($revenueChart->pluck('date')) !!};
        const data = {!! json_encode($revenueChart->pluck('total')) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: data,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#198754'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
@endsection