{{-- ======================================== FILE:
resources/views/auth/login.blade.php FUNGSI: Halaman form login
======================================== --}}
@extends('layouts.app')
{{-- ↑ Menggunakan layout dari layouts/app.blade.php Halaman ini akan "masuk" ke bagian
@yield('content') --}}
@section('content')
{{-- ↑ Mulai section yang akan ditampilkan di @yield('content') --}}

<style>
    body.login-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #2563eb 0%, #fbbf24 100%);
        background-attachment: fixed;
    }

    .login-glass {
        background: rgba(255, 255, 255, 0.85);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .login-btn {
        background: linear-gradient(90deg, #2563eb 0%, #fbbf24 100%);
        border: none;
        color: #fff;
        font-weight: 600;
        box-shadow: 0 2px 8px 0 rgba(37, 99, 235, 0.08);
        transition: background 0.2s;
    }

    .login-btn:hover {
        background: linear-gradient(90deg, #1d4ed8 0%, #f59e0b 100%);
        color: #fff;
    }

    .login-link {
        color: #2563eb;
        font-weight: 600;
    }

    .login-link:hover {
        color: #fbbf24;
        text-decoration: underline;
    }
</style>
<script>
    document.body.classList.add('login-bg');
</script>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <img src="https://www.svgrepo.com/show/424993/security.svg" alt="Login Illustration"
                class="img-fluid w-75 rounded-4 shadow-lg" style="background:rgba(255,255,255,0.2);" loading="lazy">
        </div>
        <div class="col-lg-5 col-md-8">
            <div class="login-glass p-5 animate__animated animate__fadeInDown">
                <div class="text-center mb-4">
                    <img src="https://www.svgrepo.com/show/424993/security.svg" width="48" class="mb-2" alt="Logo">
                    <h3 class="fw-bold mb-1" style="color:#2563eb">Selamat Datang!</h3>
                    <p class="text-muted">Masuk ke akun kamu untuk mulai belanja.</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
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
                            autocomplete="current-password" placeholder="••••••••" />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
                            ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn login-btn btn-lg shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </button>
                    </div>
                    <div class="text-center mb-3">
                        @if (Route::has('password.request'))
                        <a class="login-link small" href="{{ route('password.request') }}">
                            <i class="bi bi-question-circle"></i> Lupa Password?
                        </a>
                        @endif
                    </div>
                    <div class="position-relative my-4">
                        <hr />
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">
                            atau login dengan
                        </span>
                    </div>
                    <div class="d-grid mb-3">
                        <a href="{{ route('auth.google') }}"
                            class="btn btn-google-login btn-lg d-flex align-items-center justify-content-center gap-2">
                            <span
                                class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm me-2"
                                style="width:36px;height:36px;">
                                <img src="https://cdn.jsdelivr.net/npm/simple-icons@v11/icons/google.svg" width="22"
                                    height="22" alt="Google"
                                    onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg';" />
                            </span>
                            <span class="flex-grow-1 text-center fw-semibold" style="color:#2563eb;">Login dengan
                                Google</span>
                        </a>
                    </div>
                    <style>
                        .btn-google-login {
                            background: #fffbe7;
                            border: 2px solid #fbbf24;
                            color: #2563eb;
                            font-weight: 600;
                            transition: background 0.2s, border 0.2s;
                        }

                        .btn-google-login:hover {
                            background: #fbbf24;
                            color: #2563eb;
                            border-color: #2563eb;
                        }

                        .btn-google-login img {
                            display: block;
                        }
                    </style>
                    <p class="mt-4 text-center mb-0">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="login-link fw-bold">
                            Daftar Sekarang
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection {{-- ↑ Akhir dari section content --}}