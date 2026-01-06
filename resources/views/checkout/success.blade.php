@extends('layouts.app') @section('content')
<div class="container text-center" style="padding: 100px 0;">
    <div class="card shadow-sm p-5">
        <h1 class="display-4 text-success">Pesanan Berhasil!</h1>
        <p class="lead">Terima kasih telah berbelanja di <strong>Iqbaal dev</strong>.</p>
        <hr>
        <p>Pesanan Anda sedang kami proses. Silakan cek status pesanan Anda di halaman profil.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</div>
@endsection