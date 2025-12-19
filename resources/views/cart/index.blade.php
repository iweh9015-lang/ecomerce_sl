{{-- =========================================================
     FILE: resources/views/cart/index.blade.php
     HALAMAN: Keranjang Belanja (UI Modern)
     ========================================================= --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900 flex items-center gap-3">
            <i class="fas fa-shopping-cart text-blue-600"></i>
            Keranjang Belanja
        </h1>
        <a href="{{ route('catalog.index') }}"
           class="text-sm font-semibold text-blue-600 hover:underline">
            ← Lanjut Belanja
        </a>
    </div>

    @if($cart && $cart->items->count())

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="bg-white rounded-2xl shadow-sm border p-4 flex gap-4">

                        {{-- Image --}}
                        <img src="{{ $item->product->image_url }}"
                             class="w-24 h-24 rounded-xl object-cover border">

                        {{-- Info --}}
                        <div class="flex-1">
                            <a href="{{ route('catalog.show', $item->product->slug) }}"
                               class="font-bold text-slate-800 hover:text-blue-600 line-clamp-2">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $item->product->category->name }}
                            </p>

                            <div class="mt-4 flex items-center justify-between">

                                {{-- Quantity --}}
                                <form action="{{ route('cart.update', $item->id) }}"
                                      method="POST"
                                      class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <label class="text-sm text-slate-500">Qty</label>
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           max="{{ $item->product->stock }}"
                                           class="w-20 rounded-lg border-slate-300 text-center
                                                  focus:ring-blue-500 focus:border-blue-500"
                                           onchange="this.form.submit()">
                                </form>

                                {{-- Remove --}}
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Hapus produk ini?')"
                                            class="text-red-500 hover:text-red-700 text-sm font-semibold">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="text-right">
                            <p class="text-sm text-slate-500">Harga</p>
                            <p class="font-bold text-slate-800">
                                {{ $item->product->formatted_price }}
                            </p>

                            <p class="mt-4 text-sm text-slate-500">Subtotal</p>
                            <p class="font-extrabold text-blue-600">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6 h-fit sticky top-24">

                <h3 class="text-lg font-bold text-slate-900 mb-6">
                    Ringkasan Belanja
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">
                            Total Item
                        </span>
                        <span class="font-semibold">
                            {{ $cart->items->sum('quantity') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-500">
                            Total Harga
                        </span>
                        <span class="font-semibold">
                            Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <hr class="my-5">

                <div class="flex justify-between items-center mb-6">
                    <span class="text-base font-bold">Total</span>
                    <span class="text-xl font-extrabold text-blue-600">
                        Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('checkout.index') }}"
                   class="block w-full text-center py-3 rounded-xl
                          bg-blue-600 text-white font-bold
                          hover:bg-blue-700 transition">
                    <i class="fas fa-credit-card mr-2"></i>
                    Checkout
                </a>

            </div>

        </div>

    @else

        {{-- Empty Cart --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">

            <div class="w-28 h-28 flex items-center justify-center
                        rounded-full bg-blue-50 mb-6">
                <i class="fas fa-shopping-cart text-5xl text-blue-600"></i>
            </div>

            <h2 class="text-2xl font-extrabold text-slate-900 mb-2">
                Keranjang Masih Kosong
            </h2>

            <p class="text-slate-500 max-w-md mb-8">
                Kamu belum menambahkan produk ke keranjang.
                Yuk mulai belanja sekarang!
            </p>

            <a href="{{ route('catalog.index') }}"
               class="px-8 py-3 rounded-xl bg-blue-600
                      text-white font-bold
                      hover:bg-blue-700 transition">
                Mulai Belanja
            </a>

        </div>

    @endif

</div>
@endsection
