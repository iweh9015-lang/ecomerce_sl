<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'TokoBersatu - Your Online Store')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col">

        <!-- NAVBAR -->
        <header class="sticky top-0 z-50 bg-white shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">T</span>
                        </div>
                        <span class="font-bold text-lg text-gray-900 hidden sm:inline">TokoBersatu</span>
                    </a>

                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-8">
                        <div class="w-full relative">
                            <input type="text" placeholder="Cari produk..." 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="hidden lg:flex items-center gap-6">
                        <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition">Beranda</a>
                        <a href="/kategori" class="text-gray-600 hover:text-blue-600 font-medium transition">Kategori</a>
                        <a href="/tentang" class="text-gray-600 hover:text-blue-600 font-medium transition">Tentang</a>
                    </nav>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-4">
                        <button class="relative p-2 text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-heart text-lg"></i>
                            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">0</span>
                        </button>
                        <button class="relative p-2 text-gray-600 hover:text-blue-600 transition">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span class="absolute top-1 right-1 w-4 h-4 bg-blue-600 text-white text-xs rounded-full flex items-center justify-center">0</span>
                        </button>

                        @guest
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition">Login</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition">Register</a>
                        @else
                            <div class="relative group">
                                <button class="p-2 text-gray-600 hover:text-blue-600">
                                    <i class="fas fa-user-circle text-2xl"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Dashboard</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-gray-900 text-gray-300 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-white font-bold mb-4">TokoBersatu</h3>
                        <p class="text-sm">Toko online terpercaya dengan ribuan produk pilihan untuk kebutuhan Anda.</p>
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
                            <li><a href="/tentang" class="hover:text-white transition">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                            <li><a href="#" class="hover:text-white transition">Syarat Layanan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="mailto:info@tokobersatu.com" class="hover:text-white transition">Email: info@tokobersatu.com</a></li>
                            <li><a href="tel:+62123456789" class="hover:text-white transition">Telp: +62 123 456 789</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-sm text-center">
                    <p>&copy; 2025 TokoBersatu. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>

</body>
</html>

