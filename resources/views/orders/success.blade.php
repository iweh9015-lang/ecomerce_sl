@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            {{-- Animasi Centang Modern --}}
            <div class="mb-4 d-inline-block">
                <div class="success-checkmark shadow-sm">
                    <i class="bi bi-check-lg text-white"></i>
                </div>
            </div>

            {{-- Pesan Utama --}}
            <h1 class="h2 mb-3 fw-bold text-dark">Pembayaran Berhasil!</h1>
            <p class="text-muted mb-4 px-lg-5">
                Terima kasih telah berbelanja di <strong>IqbaalStore</strong>. Pesanan Anda <span class="text-primary fw-bold">#{{ $order->order_number }}</span> telah kami terima dan akan segera masuk ke tahap pengemasan.
            </p>

            {{-- Ringkasan Singkat (Opsional tapi sangat membantu) --}}
            <div class="card border-0 bg-light rounded-4 mb-4">
                <div class="card-body p-4 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Metode Pembayaran</span>
                        <span class="fw-bold text-dark">{{ $order->payment_method ?? 'Transfer Bank' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Pembayaran</span>
                        <span class="fw-bold text-primary">{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">
                    Pantau Pesanan
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-5 fw-bold">
                    Belanja Lagi
                </a>
            </div>

            {{-- Help Link --}}
            <p class="mt-5 small text-muted">
                Punya pertanyaan terkait pesanan? <a href="#" class="text-decoration-none fw-bold">Hubungi CS Kami</a>
            </p>
        </div>
    </div>
</div>

<style>
    /* Styling khusus untuk ikon sukses agar terlihat premium */
    .success-checkmark {
        width: 80px;
        height: 80px;
        background: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        border-radius: 50%;
        margin: 0 auto;
        animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes scaleIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .tracking-tight { letter-spacing: -0.5px; }
</style>
@endsection