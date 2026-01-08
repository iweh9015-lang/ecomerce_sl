<aside class="left-sidebar shadow-lg" style="background: #ffffff; border-right: 1px solid #f1f5f9; transition: all 0.3s ease;">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between px-4 py-4">
            <a href="/admin/dashboard" class="text-nowrap logo-img">
                <h4 class="fw-black text-primary mb-0" style="letter-spacing: -1px;">
                    <i class="ti ti-bolt me-2"></i>IQBAAL<span class="text-dark">DEV</span>
                </h4>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        
        <nav class="sidebar-nav scroll-sidebar px-3" data-simplebar="">
            <ul id="sidebarnav" class="list-unstyled">
                <li class="nav-small-cap mt-4 mb-2">
                    <span class="hide-menu text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 1.5px;">Main Menu</span>
                </li>
                
                <li class="sidebar-item mb-1">
                    <a class="sidebar-link custom-link rounded-3 {{ Request::is('admin/dashboard*') ? 'active' : '' }}" 
                       href="/admin/dashboard" aria-expanded="false">
                        <span class="icon-wrapper"><i class="ti ti-layout-dashboard"></i></span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link custom-link rounded-3 {{ Request::is('admin/categories*') ? 'active' : '' }}" 
                       href="/admin/categories" aria-expanded="false">
                        <span class="icon-wrapper"><i class="ti ti-category"></i></span>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link custom-link rounded-3 {{ Request::is('admin/products*') ? 'active' : '' }}" 
                       href="/admin/products" aria-expanded="false">
                        <span class="icon-wrapper"><i class="ti ti-package"></i></span>
                        <span class="hide-menu">Produk</span>
                    </a>
                </li>

                <li class="sidebar-item mb-1">
                    <a class="sidebar-link custom-link rounded-3 {{ Request::is('admin/orders*') ? 'active' : '' }}" 
                       href="/admin/orders" aria-expanded="false">
                        <span class="icon-wrapper"><i class="ti ti-receipt"></i></span>
                        <span class="hide-menu">Pesanan</span>
                    </a>
                </li>

                {{-- Section Tambahan agar terlihat lebih penuh/pro --}}
                <li class="nav-small-cap mt-4 mb-2">
                    <span class="hide-menu text-uppercase fw-bold text-muted" style="font-size: 0.65rem; letter-spacing: 1.5px;">Settings</span>
                </li>
                <li class="sidebar-item mb-1">
                    <a class="sidebar-link custom-link rounded-3" href="javascript:void(0)">
                        <span class="icon-wrapper"><i class="ti ti-settings"></i></span>
                        <span class="hide-menu">Pengaturan Toko</span>
                    </a>
                </li>
            </ul>

            {{-- Support Card (Ganti Upgrade to Pro dengan Support) --}}
            <div class="mt-5 p-3 rounded-4" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe;">
                <h6 class="fw-bold text-primary mb-1" style="font-size: 0.85rem;">Butuh Bantuan?</h6>
                <p class="text-muted small mb-3">Tim support kami siap membantu operasional Anda.</p>
                <a href="#" class="btn btn-primary btn-sm w-100 rounded-pill fw-bold">Hubungi Kami</a>
            </div>
        </nav>
    </div>
</aside>

<style>
    /* Styling Link Sidebar */
    .custom-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        color: #64748b !important;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }

    .custom-link .icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f8fafc;
        transition: all 0.2s ease;
    }

    .custom-link i {
        font-size: 1.25rem;
    }

    /* Hover State */
    .custom-link:hover {
        background-color: #f1f5f9;
        color: #2563eb !important;
    }

    .custom-link:hover .icon-wrapper {
        background: #ffffff;
        color: #2563eb;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Active State */
    .custom-link.active {
        background: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.25);
    }

    .custom-link.active .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    /* Brand Logo Animasi */
    .logo-img:hover {
        transform: scale(1.02);
        transition: transform 0.2s;
    }
</style>