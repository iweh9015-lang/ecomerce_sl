{{-- resources/views/partials/navbar.blade.php --}}

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
    <div class="container">
        {{-- Logo & Brand --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="bg-primary rounded-3 p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="bi bi-bag-heart-fill text-white fs-5"></i>
            </div>
            <span class="fw-bold text-dark tracking-tight">Iqbaal<span class="text-primary">Store</span></span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="bi bi-list fs-2"></i>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form (Pusat) --}}
            <form class="d-flex mx-auto mt-3 mt-lg-0" style="max-width: 450px; width: 100%;" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group search-group bg-light rounded-pill p-1 border">
                    <input type="text" name="q" class="form-control bg-transparent border-0 ps-3 shadow-none" 
                           placeholder="Cari produk impianmu..." value="{{ request('q') }}">
                    <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" 
                            type="submit" style="width: 38px; height: 38px;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link custom-nav-link fw-bold text-dark px-3" href="{{ route('catalog.index') }}">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-grid-fill small"></i> Katalog
                        </span>
                    </a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link nav-icon-pill position-relative text-dark d-flex align-items-center justify-content-center" 
                           href="{{ route('wishlist.index') }}" title="Wishlist">
                            <i class="bi bi-heart fs-5"></i>
                            @php $wishlistCount = auth()->user()->wishlists()->count(); @endphp
                            @if($wishlistCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white"
                                      style="font-size: 0.6rem; padding: 0.4em 0.6em;">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item">
                        <a class="nav-link nav-icon-pill position-relative text-dark d-flex align-items-center justify-content-center" 
                           href="{{ route('cart.index') }}" title="Keranjang">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary border border-2 border-white"
                                      style="font-size: 0.6rem; padding: 0.4em 0.6em;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0 shadow-none" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            <div class="avatar-container p-1 border rounded-circle border-primary-subtle shadow-sm bg-white">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D6EFD&color=fff' }}" 
                                     class="rounded-circle object-fit-cover" width="30" height="30" alt="User">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 py-2" style="border-radius: 15px; min-width: 220px;">
                            <li class="px-3 py-2 mb-2 bg-light mx-2 rounded-3">
                                <p class="mb-0 small fw-bold text-dark">{{ auth()->user()->name }}</p>
                                <small class="text-muted d-block text-truncate" style="font-size: 0.7rem;">{{ auth()->user()->email }}</small>
                            </li>
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i> Pesanan Saya</a></li>
                            
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-primary fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Guest Links --}}
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link fw-bold text-dark" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Global fixes */
    .navbar-brand span { letter-spacing: -0.5px; }
    .search-group:focus-within { border-color: #0d6efd !important; box-shadow: 0 0 10px rgba(13, 110, 253, 0.1) !important; }
    
    /* Katalog Underline Effect */
    .custom-nav-link { position: relative; transition: all 0.3s ease; }
    .custom-nav-link::after { 
        content: ''; position: absolute; width: 0; height: 2px; 
        bottom: 5px; left: 50%; background-color: #2563eb; 
        transition: all 0.3s ease; transform: translateX(-50%); border-radius: 2px; 
    }
    .custom-nav-link:hover { color: #2563eb !important; }
    .custom-nav-link:hover::after { width: 50%; }

    /* Icons (Wishlist & Cart) */
    .nav-icon-pill { 
        width: 40px; height: 40px; border-radius: 12px; 
        transition: all 0.3s ease; background: transparent; 
    }
    .nav-icon-pill:hover { background: #f0f7ff; color: #0d6efd !important; transform: translateY(-2px); }

    /* Dropdown Improvements */
    .dropdown-item { transition: all 0.2s; border-radius: 8px; margin: 0 8px; width: auto; }
    .dropdown-item:hover { background-color: #f8f9fa; transform: translateX(5px); color: #0d6efd; }
    
    .avatar-container { transition: all 0.3s ease; }
    .avatar-container:hover { transform: scale(1.1) rotate(5deg); border-color: #0d6efd !important; }
</style>