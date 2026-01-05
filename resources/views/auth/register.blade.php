@extends('layouts.app')

@section('content')
<style>
    body.register-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #2563eb 0%, #fbbf24 100%);
        background-attachment: fixed;
    }

    .register-glass {
        background: rgba(255, 255, 255, 0.85);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .register-btn {
        background: linear-gradient(90deg, #2563eb 0%, #fbbf24 100%);
        border: none;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 2px 8px 0 rgba(37, 99, 235, 0.08);
        transition: background 0.2s;
    }

    .register-btn:hover {
        background: linear-gradient(90deg, #1d4ed8 0%, #f59e0b 100%);
        color: #fff;
    }

    .register-link {
        color: #2563eb;
        font-weight: 600;
    }

    .register-link:hover {
        color: #fbbf24;
        text-decoration: underline;
    }
</style>
<script>
    document.body.classList.add('register-bg');
</script>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <img src="https://cdn.jsdelivr.net/gh/undraw/undraw@master/static/undraw_sign_up_n6im.svg"
                alt="Register Illustration" class="img-fluid w-75 rounded-4 shadow-lg"
                style="background:rgba(255,255,255,0.2);" loading="lazy">
        </div>
        <div class="col-lg-5 col-md-8">
            <div class="register-glass p-5 animate__animated animate__fadeInDown">
                <div class="text-center mb-4">
                    <img src="{{ asset('favicon.ico') }}" width="48" class="mb-2" alt="Logo">
                    <h3 class="fw-bold mb-1" style="color:#2563eb">Buat Akun Baru</h3>
                    <p class="text-muted">Daftar untuk mulai belanja di toko kami.</p>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            placeholder="Nama lengkap">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="nama@email.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password" placeholder="Minimal 8 karakter">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Ulangi password">
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn register-btn btn-lg shadow-sm">
                            <i class="bi bi-person-plus me-2"></i> Daftar
                        </button>
                    </div>
                    <div class="position-relative my-4">
                        <hr />
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">
                            atau daftar dengan
                        </span>
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <a href="{{ route('auth.google') }}"
                            class="btn btn-outline-warning btn-lg text-primary fw-bold border-2"
                            style="border-color:#fbbf24 !important;">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" class="me-2" />
                            Daftar dengan Google
                        </a>
                    </div>
                    <p class="mt-4 text-center mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="register-link fw-bold">
                            Login
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection