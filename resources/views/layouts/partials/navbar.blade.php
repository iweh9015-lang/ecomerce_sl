{{-- resources/views/layouts/partials/navbar.blade.php --}}
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            {{-- Mobile Toggler --}}
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
            {{-- Link ke Toko (View Website) --}}
            <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="/" target="_blank" title="Lihat Toko">
                    <i class="ti ti-world"></i>
                </a>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                
                {{-- Nama & Role Admin --}}
                <li class="nav-item d-none d-md-block me-2 text-end">
                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.85rem">{{ Auth::user()->name }}</p>
                    <small class="text-muted" style="font-size: 0.75rem">Administrator</small>
                </li>

                {{-- User Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" 
                             alt="profile" width="38" height="38" class="rounded-circle border border-2 border-primary-subtle">
                    </a>
                    
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up border-0 shadow-lg mt-3" aria-labelledby="drop2" style="min-width: 240px; border-radius: 15px;">
                        <div class="message-body p-3">
                            <div class="px-3 py-2 mb-2 bg-light rounded-3 d-md-none">
                                <p class="mb-0 fw-bold text-dark">{{ Auth::user()->name }}</p>
                                <small class="text-muted">Administrator</small>
                            </div>

                            <a href="javascript:void(0)" class="d-flex align-items-center gap-3 dropdown-item rounded-3 py-2">
                                <i class="ti ti-user fs-5 text-primary"></i>
                                <p class="mb-0 fs-3">Profil Saya</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-3 dropdown-item rounded-3 py-2">
                                <i class="ti ti-settings fs-5 text-primary"></i>
                                <p class="mb-0 fs-3">Pengaturan</p>
                            </a>

                            <hr class="dropdown-divider opacity-50">

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-outline-danger w-100 mt-2 rounded-pill fw-bold">
                                <i class="ti ti-logout me-1"></i> Keluar
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>