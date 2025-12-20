<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TokoIqbaal') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-['Inter'] bg-slate-100 text-slate-800 antialiased">

<div class="min-h-screen flex flex-col">

    <!-- TOP BAR -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm py-1.5 text-center font-medium">
        🛍️ Selamat datang di <b>TokoIqbaal</b> — Belanja aman & terpercaya
    </div>

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50">
        <div class="bg-white/90 backdrop-blur-xl border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between h-14">

                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-indigo-600
                                    rounded-xl flex items-center justify-center
                                    text-white font-extrabold shadow">
                            TI
                        </div>
                        <span class="text-lg font-extrabold">
                            Toko<span class="text-blue-600">Iqbaal</span>
                        </span>
                    </a>

                    <!-- Search -->
                    <div class="hidden md:block w-full max-w-sm mx-8">
                        <div class="relative">
                            <input type="text"
                                   placeholder="Cari produk..."
                                   class="w-full rounded-lg border border-slate-300
                                          px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500
                                          focus:border-blue-500 outline-none">
                            <i class="fas fa-search absolute right-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Menu -->
                    <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold">
                        <a href="/" class="hover:text-blue-600 transition">Beranda</a>
                        <a href="{{ route('catalog.index') }}" class="hover:text-blue-600 transition">Katalog</a>
                        <a href="#tentang" class="hover:text-blue-600 transition">Tentang</a>
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Panel admin</a>
                    </nav>

                    <!-- Actions -->
                    <div class="flex items-center gap-3">

                        @auth
                            <!-- Wishlist -->
                            <a href="{{ route('wishlist.index') }}"
                               class="relative p-2 hover:text-red-500 transition">
                                <i class="fas fa-heart"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4
                                             bg-red-500 text-white text-xs
                                             rounded-full flex items-center justify-center">
                                    {{ auth()->user()->wishlist()->count() }}
                                </span>
                            </a>

                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}"
                               class="relative p-2 hover:text-blue-600 transition">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="absolute -top-1 -right-1 w-4 h-4
                                             bg-blue-600 text-white text-xs
                                             rounded-full flex items-center justify-center">
                                    {{ auth()->user()->cart ? auth()->user()->cart->items()->count() : 0 }}
                                </span>
                            </a>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-blue-600">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 text-sm font-semibold rounded-lg
                                      bg-blue-600 text-white hover:bg-blue-700 transition">
                                Daftar
                            </a>
                        @else
                            <!-- User Menu -->
                            <div class="relative group">
                                <button class="p-2 hover:text-blue-600">
                                    <i class="fas fa-user-circle text-xl"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg
                                            opacity-0 invisible group-hover:opacity-100
                                            group-hover:visible transition border">
                                    <a href="{{ route('home') }}"
                                       class="block px-4 py-2 hover:bg-blue-50">Dashboard</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="w-full text-left px-4 py-2 hover:bg-blue-50">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest

                        <!-- Mobile -->
                        <button class="lg:hidden p-2">
                            <i class="fas fa-bars text-lg"></i>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ERROR -->
    @if ($errors->any())
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- CONTENT -->
    <main class="flex-1 py-6">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">

            <div>
                <h3 class="text-white font-bold text-lg mb-2">TokoIqbaal</h3>
                <p class="text-slate-400">
                    Toko online terpercaya dengan produk pilihan terbaik.
                </p>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-2">Kategori</h4>
                <ul class="space-y-1">
                    <li>Elektronik</li>
                    <li>Fashion</li>
                    <li>Rumah & Hidup</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-2">Perusahaan</h4>
                <ul class="space-y-1">
                    <li>Tentang Kami</li>
                    <li>Kebijakan Privasi</li>
                    <li>Syarat Layanan</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold mb-2">Kontak</h4>
                <p class="text-slate-400">
                    info@tokoiqbaal.com<br>
                    +62 812 xxxx xxxx
                </p>
            </div>

        </div>

        <div class="border-t border-slate-800 text-center text-xs py-4">
            © {{ date('Y') }} TokoIqbaal. All rights reserved.
        </div>
    </footer>

</div>
@stack('scripts')
<script>
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(() => {
        alert('Produk berhasil ditambahkan ke keranjang');
        location.reload();
    })
    .catch(() => {
        alert('Terjadi kesalahan');
    });
}
</script>


</body>
</html>
