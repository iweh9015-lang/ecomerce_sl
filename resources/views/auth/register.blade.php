@extends('layouts.app')

@section('content')
<style>
    /* Background Animasi Biru Professional - Sama dengan Login */
    body.register-bg {
        min-height: 100vh;
        background: linear-gradient(-45deg, #0f172a, #1e3a8a, #2563eb, #1d4ed8);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
        background-attachment: fixed;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .register-glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Floating Input Styling */
    .form-label {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.85rem;
        margin-left: 0.2rem;
    }

    .input-group {
        transition: all 0.3s ease;
    }

    .input-group-text {
        background-color: #f8fafc;
        border-right: none;
        color: #64748b;
        border-radius: 1rem 0 0 1rem !important;
    }

    .form-control {
        border-radius: 0 1rem 1rem 0 !important;
        padding: 0.8rem 1rem;
        border-left: none;
        background-color: #f8fafc;
        border-color: #e2e8f0;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #e2e8f0;
        background-color: #fff;
    }

    .input-group:focus-within {
        transform: translateY(-2px);
    }

    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: #2563eb;
        color: #2563eb;
    }

    /* Button Styling */
    .register-btn {
        background: #2563eb;
        border: none;
        border-radius: 1rem;
        padding: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .register-btn:hover {
        background: #1e40af;
        transform: scale(1.02);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4);
        color: white;
    }

    .btn-google-login {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 1rem;
        color: #1e293b;
        font-weight: 600;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-google-login:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .register-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.2s;
    }

    .register-link:hover {
        color: #1e40af;
        text-decoration: underline;
    }

    .hr-text {
        display: flex;
        align-items: center;
        text-align: center;
        color: #94a3b8;
    }

    .hr-text::before, .hr-text::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }

    .hr-text:not(:empty)::before { margin-right: .75em; }
    .hr-text:not(:empty)::after { margin-left: .75em; }
</style>

<script>
    document.body.classList.add('register-bg');
</script>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center text-white p-5">
            <div class="animate__animated animate__fadeInLeft text-center">
                <h1 class="display-4 fw-black">Iqbaal<span class="text-info">Dev</span></h1>
                <p class="lead opacity-75 mt-3">Bergabunglah sekarang dan nikmati layanan premium kami dengan satu langkah mudah.</p>
                <div class="d-flex gap-3 mt-4 justify-content-center">
                    <span class="badge rounded-pill bg-white bg-opacity-10 p-2 px-3 border border-white border-opacity-25"><i class="bi bi-shield-check me-2"></i>Secure</span>
                    <span class="badge rounded-pill bg-white bg-opacity-10 p-2 px-3 border border-white border-opacity-25"><i class="bi bi-lightning-charge me-2"></i>Fast</span>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-8">
            <div class="register-glass p-4 p-md-5 animate__animated animate__fadeInUp">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark mb-2">Buat Akun</h2>
                    <p class="text-muted small">Lengkapi data untuk pendaftaran</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-uppercase">Full Name</label>
                        <div class="input-group shadow-sm border-0">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required placeholder="Nama lengkap">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase">Email Address</label>
                        <div class="input-group shadow-sm border-0">
                            <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required placeholder="email@domain.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase">Password</label>
                        <div class="input-group shadow-sm border-0">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required placeholder="Masukkan password">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase">Confirm Password</label>
                        <div class="input-group shadow-sm border-0">
                            <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
                            <input type="password" class="form-control"
                                name="password_confirmation" required placeholder="Masukan ulang password">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn register-btn shadow-lg">
                            Daftar Sekarang <i class="bi bi-person-plus-fill ms-2"></i>
                        </button>
                    </div>

                    <div class="hr-text my-4 small fw-bold">OR REGISTER WITH</div>

                    <div class="d-grid">
                        <a href="{{ route('auth.google') }}" class="btn btn-google-login shadow-sm">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2" alt="Google">
                            Google Account
                        </a>
                    </div>

                    <p class="text-center mt-5 mb-0 small text-muted">
                        Sudah punya akun? <a href="{{ route('login') }}" class="register-link">Login Saja</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection