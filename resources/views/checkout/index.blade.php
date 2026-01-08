@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f7f9; }
    
    /* Progress Step Indicator (Tambahan) */
    .step-indicator { display: flex; align-items: center; justify-content: start; gap: 15px; margin-bottom: 2rem; }
    .step { width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; }
    .step.active { background: #2563eb; color: white; box-shadow: 0 0 15px rgba(37, 99, 235, 0.3); }

    /* Card & Forms */
    .checkout-card { border: none; border-radius: 1.5rem; transition: transform 0.3s; }
    .form-section-title { font-weight: 800; color: #1e293b; display: flex; align-items: center; gap: 12px; }
    .form-section-title i { color: #2563eb; background: #eff6ff; padding: 10px; border-radius: 12px; }
    
    /* Payment Method UI */
    .payment-option { cursor: pointer; position: relative; }
    .payment-option input { position: absolute; opacity: 0; width: 0; height: 0; }
    .payment-box { 
        border: 1.5px solid #e2e8f0; border-radius: 1rem; padding: 15px; 
        display: flex; align-items: center; justify-content: space-between; 
        transition: all 0.2s ease; background: white; 
    }
    .payment-option input:checked + .payment-box { 
        border-color: #2563eb; background: #f0f7ff; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08); 
    }
    .payment-option input:checked + .payment-box .check-icon { display: block !important; }
    .payment-logo { height: 25px; object-fit: contain; filter: grayscale(100%); transition: 0.3s; }
    .payment-option input:checked + .payment-box .payment-logo { filter: grayscale(0%); }

    /* Sticky Summary Custom Scrollbar */
    .summary-list::-webkit-scrollbar { width: 5px; }
    .summary-list::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

<div class="container py-5">
    {{-- Header & Progress --}}
    <div class="checkout-header animate__animated animate__fadeIn">
        <div class="step-indicator">
            <div class="step">1</div><small class="text-muted">Keranjang</small>
            <div class="bg-muted" style="height: 2px; width: 30px; background: #e2e8f0;"></div>
            <div class="step active">2</div><small class="fw-bold text-dark">Pembayaran</small>
        </div>
        <h1 class="fw-black text-dark mb-1">Finalisasi Pesanan</h1>
        <p class="text-muted small">Konfirmasi alamat dan pilih metode pembayaran favoritmu.</p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" class="checkout-form">
        @csrf

        <div class="row g-4">
            {{-- Bagian Kiri: Alamat & Pembayaran --}}
            <div class="col-lg-8">
                
                {{-- Alamat Pengiriman --}}
                <div class="card checkout-card shadow-sm mb-4 animate__animated animate__fadeInLeft">
                    <div class="card-body p-4">
                        <h2 class="form-section-title mb-4">
                            <i class="bi bi-truck"></i> Informasi Pengiriman
                        </h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Penerima</label>
                                <input type="text" name="name" class="form-control rounded-3 py-2" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">+62</span>
                                    <input type="text" name="phone" class="form-control border-start-0" placeholder="8123456xxx" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="form-control rounded-3" placeholder="Contoh: Jl. Sudirman No. 1, Blok A" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Metode Pembayaran (Versi Lengkap) --}}
                <div class="card checkout-card shadow-sm animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
                    <div class="card-body p-4">
                        <h2 class="form-section-title mb-4">
                            <i class="bi bi-credit-card-2-front"></i> Metode Pembayaran
                        </h2>

                        {{-- Virtual Account / Transfer --}}
                        <p class="small fw-bold text-muted mb-3">Transfer Bank / Virtual Account</p>
                        <div class="row g-2 mb-4">
                            @foreach(['BCA', 'BNI', 'Mandiri', 'BRI'] as $bank)
                            <div class="col-md-6">
                                <label class="payment-option w-100">
                                    <input type="radio" name="payment_method" value="{{ $bank }}" required>
                                    <div class="payment-box">
                                        <span class="small fw-bold text-dark">{{ $bank }} Virtual Account</span>
                                        <i class="bi bi-check-circle-fill text-primary check-icon" style="display:none;"></i>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        {{-- E-Wallet --}}
                        <p class="small fw-bold text-muted mb-3">E-Wallet (Gopay/OVO/Dana)</p>
                        <div class="row g-2 mb-4">
                            @foreach(['GoPay', 'OVO', 'Dana', 'ShopeePay'] as $ewallet)
                            <div class="col-6 col-md-3">
                                <label class="payment-option w-100 text-center">
                                    <input type="radio" name="payment_method" value="{{ $ewallet }}">
                                    <div class="payment-box d-block py-3">
                                        <div class="small fw-bold text-dark mb-1">{{ $ewallet }}</div>
                                        <i class="bi bi-check-circle-fill text-primary check-icon small" style="display:none;"></i>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        {{-- Retail --}}
                        <p class="small fw-bold text-muted mb-3">Gerai Retail</p>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="payment-option w-100">
                                    <input type="radio" name="payment_method" value="Alfamart">
                                    <div class="payment-box">
                                        <span class="small fw-bold text-dark">Alfamart / Alfamidi</span>
                                        <i class="bi bi-check-circle-fill text-primary check-icon" style="display:none;"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="payment-option w-100">
                                    <input type="radio" name="payment_method" value="Indomaret">
                                    <div class="payment-box">
                                        <span class="small fw-bold text-dark">Indomaret / Ceriamart</span>
                                        <i class="bi bi-check-circle-fill text-primary check-icon" style="display:none;"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Summary --}}
            <div class="col-lg-4">
                <div class="card summary-card shadow-lg sticky-top rounded-4 border-0 overflow-hidden" style="top: 100px;">
                    <div class="card-header bg-dark py-3 border-0">
                        <h5 class="text-white mb-0 fw-bold small text-center">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="summary-list mb-4" style="max-height: 250px; overflow-y: auto;">
                            @foreach($cart->items as $item)
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-3 p-1 me-3 border" style="width: 50px; height: 50px;">
                                    <img src="{{ $item->product->image_url }}" class="img-fluid rounded-2 object-fit-cover w-100 h-100">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="small fw-bold text-dark mb-0">{{ Str::limit($item->product->name, 25) }}</h6>
                                    <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="small fw-bold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="bg-light p-3 rounded-4 mb-4 border">
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Total Belanja</span>
                                <span class="text-dark fw-bold">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">Ongkos Kirim</span>
                                <span class="text-success fw-bold">Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold text-dark">Total Tagihan</span>
                                <span class="h5 mb-0 fw-black text-primary">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm py-3 mb-3">
                            Konfirmasi & Bayar <i class="bi bi-shield-lock ms-2"></i>
                        </button>
                        {{-- Ganti bagian div text-center paling bawah di dalam card-body summary-card --}}
<div class="text-center mt-3 pt-3 border-top">
    <p class="small text-muted mb-2" style="font-size: 0.7rem;">METODE PEMBAYARAN AMAN</p>
   <div class="d-flex justify-content-center align-items-center gap-3 grayscale-img opacity-75">
    {{-- Visa --}}
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" height="12">
    {{-- Mastercard --}}
    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" height="18">
    {{-- GPN (Gerbang Pembayaran Nasional) - Menambah kesan lokal Indonesia yang kuat --}}
    <img src="https://upload.wikimedia.org/wikipedia/id/thumb/b/b1/Gerbang_Pembayaran_Nasional_logo.svg/1200px-Gerbang_Pembayaran_Nasional_logo.svg.png" alt="GPN" height="18">
</div>
    <div class="mt-2">
        <span class="badge bg-light text-success border rounded-pill" style="font-size: 0.65rem;">
            <i class="bi bi-shield-fill-check me-1"></i> Terenkripsi SSL 256-bit
        </span>
    </div>
</div>

{{-- Tambahkan sedikit CSS di bagian <style> atas --}}
<style>
    .grayscale-img img {
        filter: grayscale(100%);
        transition: all 0.3s ease;
    }
    .grayscale-img img:hover {
        filter: grayscale(0%);
    }
</style>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection