<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register - {{ config('app.name') }}</title>
    <style>
        :root{--primary:#2563eb;--bg:#f3f4f6;--card:#ffffff}
        html,body{height:100%}
        body{font-family:system-ui,Segoe UI,Roboto,"Helvetica Neue",Arial,sans-serif;margin:0;background:var(--bg);display:flex;align-items:center;justify-content:center;padding:2rem}
        .auth-card{background:var(--card);width:100%;max-width:420px;border-radius:10px;box-shadow:0 8px 30px rgba(2,6,23,0.08);padding:1.6rem}
        h1{font-size:1.25rem;margin:0 0 0.75rem;color:#0f172a}
        .lead{color:#6b7280;font-size:0.95rem;margin-bottom:1rem}
        .error-box{background:#fff1f2;color:#991b1b;border:1px solid #fecaca;padding:0.75rem;border-radius:8px;margin-bottom:1rem}
        .form-group{margin-bottom:0.75rem}
        label{display:block;font-size:0.875rem;color:#374151;margin-bottom:0.25rem}
        input{width:100%;padding:0.6rem 0.75rem;border:1px solid #e6e7eb;border-radius:8px;font-size:0.95rem}
        input:focus{outline:none;box-shadow:0 0 0 4px rgba(37,99,235,0.08);border-color:var(--primary)}
        .btn{display:inline-block;background:var(--primary);color:#ffffff;border:none;padding:0.65rem 0.9rem;border-radius:8px;cursor:pointer;width:100%;font-weight:600}
        .btn:hover{background:#1e40af}
        .muted{color:#6b7280;font-size:0.9rem;margin-top:0.75rem;text-align:center}
        .muted a{color:var(--primary);text-decoration:none}
    </style>
</head>
<body>
    <div class="auth-card" role="main">
        <h1>Register</h1>
        <p class="lead">Buat akun baru untuk melanjutkan.</p>

        @if($errors->any())
        <div class="error-box">
            <ul style="margin:0;padding-left:1.1rem">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Daftar</button>
            </div>
        </form>

        <p class="muted">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
</body>
</html>
