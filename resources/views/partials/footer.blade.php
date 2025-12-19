{{-- ================================================
     FILE: resources/views/partials/footer.blade.php
     FUNGSI: Footer website
     ================================================ --}}

<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-3">
                    <i class="bi bi-bag-heart-fill me-2"></i>TokoOnline
                </h5>
                <p class="text-secondary">
                    Toko online terpercaya dengan berbagai produk berkualitas.
                    Belanja mudah, aman, dan nyaman.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-secondary fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-secondary fs-5"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-secondary fs-5"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-secondary fs-5"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-3">Menu</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="text-secondary text-decoration-none">
                            Katalog Produk
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none">Tentang Kami</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none">Kontak</a>
                    </li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-3">Bantuan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none">FAQ</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none">Cara Belanja</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-secondary text-decoration-none">Kebijakan Privasi</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        Jl. Contoh No. 123, Bandung
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        (022) 123-4567
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        info@tokoonline.com
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary mb-0 small">
                    &copy; {{ date('Y') }} TokoOnline. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <img src="{{ asset('images/payment-methods.png') }}" alt="Payment Methods" height="30">
            </div>
        </div>
    </div>
</footer>
