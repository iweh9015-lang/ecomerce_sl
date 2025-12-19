{{-- ================================================
     FILE: resources/views/layouts/admin.blade.php
     FUNGSI: Master layout untuk halaman admin
     ================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link i {
            width: 24px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar d-flex flex-column" style="width: 260px;">
            {{-- Brand --}}
            <div class="p-3 border-bottom border-secondary">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center">
                    <i class="bi bi-shop fs-4 me-2"></i>
                    <span class="fs-5 fw-bold">Admin Panel</span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow-1 py-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}"
                           class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam me-2"></i> Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-folder me-2"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}"
                           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-receipt me-2"></i> Pesanan
                            {{-- Logic PHP di View ini hanya untuk contoh.
                                 Best Practice: Gunakan View Composer atau inject variable dari Controller.
                                 Jangan query database langsung di Blade view di production app! --}}
                            @php
                                $pendingCount = \App\Models\Order::where('status', 'pending')
                                    ->where('payment_status', 'paid')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning text-dark ms-auto">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people me-2"></i> Pengguna
                        </a>
                    </li>

                    <li class="nav-item mt-3">
                        <span class="nav-link text-muted small text-uppercase">Laporan</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.reports.sales') }}"
                           class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="bi bi-graph-up me-2"></i> Laporan Penjualan
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- User Info --}}
            <div class="p-3 border-top border-secondary">
                <div class="d-flex align-items-center text-white">
                    <img src="{{ auth()->user()->avatar_url }}"
                         class="rounded-circle me-2" width="36" height="36">
                    <div class="flex-grow-1">
                        <div class="small fw-medium">{{ auth()->user()->name }}</div>
                        <div class="small text-muted">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm py-3 px-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm me-2" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Toko
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-4 pt-3">
                @include('partials.flash-messages')
            </div>

            {{-- Page Content --}}
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>