@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold mb-8">🛒 Daftar Produk</h1>

    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach ($products as $product)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-5 flex flex-col">

                    {{-- Gambar Produk --}}
                    <div class="mb-4">
                        <img
                            src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300x200' }}"
                            class="w-full h-48 object-cover rounded-lg"
                            alt="{{ $product->name }}"
                        >
                    </div>

                    {{-- Nama Produk --}}
                    <h2 class="text-lg font-semibold mb-2">
                        {{ $product->name }}
                    </h2>

                    {{-- Harga --}}
                    <p class="text-green-600 font-bold mb-4">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    {{-- Tombol --}}
                    <button
                        onclick="addToCart({{ $product->id }})"
                        class="mt-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition"
                    >
                        ➕ Tambah ke Keranjang
                    </button>

                </div>
            @endforeach

        </div>
    @else
        <p class="text-gray-500">Produk belum tersedia.</p>
    @endif

</div>

{{-- SCRIPT AJAX --}}
<script>
function addToCart(productId) {
    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
        } else {
            alert("Gagal menambahkan ke keranjang");
        }
    })
    .catch(() => {
        alert("Terjadi kesalahan");
    });
}
</script>
@endsection
