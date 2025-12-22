{{-- resources/views/checkout/index.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Form Alamat --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Informasi Pengiriman</h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" name="phone"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="address" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow sticky top-4">
                        <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>

                        <div class="space-y-4 max-h-60 overflow-y-auto mb-4">
                            @foreach($cart->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                    <span class="font-medium">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-base font-bold">
                                <span>Total</span>
                                <span>Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                            Buat Pesanan
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>