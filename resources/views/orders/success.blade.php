@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h1 class="h3 mb-4 text-success fw-bold">Pembayaran Berhasil!</h1>
    <p class="mb-4">Terima kasih, pesanan Anda telah berhasil dibayar dan akan segera diproses.</p>
    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">Lihat Detail Pesanan</a>
</div>
@endsection