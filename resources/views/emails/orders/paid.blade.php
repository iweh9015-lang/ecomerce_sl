{{-- resources/views/emails/orders/paid.blade.php --}}

<x-mail::message>
# Halo, {{ $order->user->name }}

Terima kasih! Pembayaran untuk pesanan **#{{ $order->order_number }}** telah kami terima.
Kami sedang memproses pesanan Anda.

<x-mail::table>
| Produk | Qty | Harga |
|:-------|:---:|:------|
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | Rp {{ number_format($item->price, 0, ',', '.') }} |
@endforeach
| **Total** | | **Rp {{ number_format($order->total_amount, 0, ',', '.') }}** |
</x-mail::table>

<x-mail::button :url="route('orders.show', $order)">
Lihat Detail Pesanan
</x-mail::button>

Jika ada pertanyaan, silakan balas email ini.

Salam,<br>
{{ config('app.name') }}
</x-mail::message>