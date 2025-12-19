<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TokoIqbaal') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- TOP BANNER -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-2 text-center text-sm">
            <span class="font-bold text-lg">🛍️ TOKO IQBAAL</span> - Belanja Online Terpercaya
        </div>

        <!-- NAVBAR -->
        <header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2 hover:opacity-80 transition">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white font-bold text-lg">剌</span>
                        </div>
                        <span class="font-bold text-xl text-gray-900 hidden sm:inline">TokoIqbaal</span>
                    </a>

                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-8">
                        <div class="w-full relative">
                            <input type="text" placeholder="Cari produk, kategori..."
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <button
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="hidden lg:flex items-center gap-8">
                        <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition">Beranda</a>
                        <a href="{{ route('catalog.index') }}"
                            class="text-gray-600 hover:text-blue-600 font-medium transition">Katalog</a>
                        <a href="#tentang" class="text-gray-600 hover:text-blue-600 font-medium transition">Tentang</a>
                    </nav>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        @auth
                            <a href="{{ route('wishlist.index') }}"
                                class="relative p-2 text-gray-600 hover:text-red-500 transition" title="Wishlist">
                                <i class="fas fa-heart text-lg"></i>
                                <span
                                    class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                    {{ auth()->user()->wishlist()->count() }}
                                </span>
                            </a>
                            <a href="{{ route('cart.index') }}"
                                class="relative p-2 text-gray-600 hover:text-blue-600 transition" title="Keranjang">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span
                                    class="absolute top-0 right-0 w-5 h-5 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                    {{ auth()->user()->cart ? auth()->user()->cart->items()->count() : 0 }}
                                </span>
                            </a>
                        @else
                            <button class="relative p-2 text-gray-600 hover:text-red-500 transition" title="Wishlist">
                                <i class="fas fa-heart text-lg"></i>
                                <span
                                    class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">0</span>
                            </button>
                            <button class="relative p-2 text-gray-600 hover:text-blue-600 transition" title="Keranjang">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span
                                    class="absolute top-0 right-0 w-5 h-5 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center font-bold">0</span>
                            </button>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}"
                                class="hidden sm:inline px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition">Masuk</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition shadow-sm">Daftar</a>
                        @else
                            <div class="relative group">
                                <button class="p-2 text-gray-600 hover:text-blue-600 transition">
                                    <i class="fas fa-user-circle text-2xl"></i>
                                </button>
                                <div
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 border border-gray-100">
                                    <a href="{{ route('home') }}"
                                        class="block px-4 py-3 text-gray-700 hover:bg-blue-50 border-b border-gray-100">Dashboard</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-3 text-gray-700 hover:bg-blue-50">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 text-gray-600 hover:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        @if ($errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- CONTENT -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-gray-900 text-gray-300 mt-16 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-white font-bold mb-4 text-lg">Tokoiqbaal</h3>
                        <p class="text-sm leading-relaxed">Toko online terpercaya dengan ribuan produk pilihan untuk
                            kebutuhan Anda.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-4">Kategori</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">Elektronik</a></li>
                            <li><a href="#" class="hover:text-white transition">Fashion</a></li>
                            <li><a href="#" class="hover:text-white transition">Rumah & Hidup</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-white transition">Syarat Layanan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="mailto:info@tokoiqbaal.com" class="hover:text-white transition">Email:
                                    info@tokoiqbaal.com</a></li>
                            <li><a href="tel:+62123456789" class="hover:text-white transition">Telp: +62 123 456
                                    789</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-sm text-center">
                    <p>&copy; 2025 TokoIqbaal. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')

    <script>
        // Global cart dan wishlist functions
        function addToCart(productId, event) {
            if (event) event.preventDefault();

            // Check if user is authenticated
            @if (auth()->guest())
                if (confirm('Anda harus login terlebih dahulu. Ingin login sekarang?')) {
                    window.location.href = '{{ route('login') }}';
                }
                return;
            @endif

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            console.log('Adding to cart:', productId);

            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(res => {
                    console.log('Response status:', res.status);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.text().then(text => {
                        console.log('Raw response:', text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error('Invalid JSON response: ' + text);
                        }
                    });
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Gagal menambahkan ke keranjang'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan: ' + err.message);
                });
        }

        function toggleWishlist(productId, event) {
            if (event) event.preventDefault();

            // Check if user is authenticated
            @if (auth()->guest())
                if (confirm('Anda harus login terlebih dahulu. Ingin login sekarang?')) {
                    window.location.href = '{{ route('login') }}';
                }
                return;
            @endif

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            console.log('Toggling wishlist:', productId);

            fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(res => {
                    console.log('Response status:', res.status);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    return res.text().then(text => {
                        console.log('Raw response:', text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            throw new Error('Invalid JSON response: ' + text);
                        }
                    });
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Gagal memperbarui wishlist'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan: ' + err.message);
                });
        }
    </script>
</body>

</html>
