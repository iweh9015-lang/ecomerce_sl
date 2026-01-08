{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
        <div class="row g-5">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-12">
                <a class="d-flex align-items-center mb-3 text-decoration-none" href="{{ route('home') }}">
                    <div class="bg-primary rounded-3 p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="bi bi-bag-heart-fill text-white fs-5"></i>
                    </div>
                    <h4 class="fw-bold text-white mb-0 tracking-tight">Iqbaal<span class="text-primary">Store</span></h4>
                </a>
                {{-- Menggunakan text-white-50 agar lebih terang dibanding text-muted biasa di bg-dark --}}
                <p class="text-white-50 small lh-lg">
                    Destinasi utama belanja online Anda untuk produk berkualitas tinggi. Kami berkomitmen memberikan pengalaman belanja yang mudah, aman, dan penuh kasih sayang.
                </p>
                <div class="d-flex gap-2 mt-4">
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-6 col-lg-2">
                <h6 class="text-white fw-bold mb-4">Belanja</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="{{ route('catalog.index') }}">Semua Produk</a></li>
                    <li class="mb-2"><a href="#">Produk Terbaru</a></li>
                    <li class="mb-2"><a href="#">Promo Spesial</a></li>
                    <li class="mb-2"><a href="#">Testimoni</a></li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-6 col-lg-2">
                <h6 class="text-white fw-bold mb-4">Bantuan</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="#">Tentang Kami</a></li>
                    <li class="mb-2"><a href="#">Cara Belanja</a></li>
                    <li class="mb-2"><a href="#">Ketentuan Layanan</a></li>
                    <li class="mb-2"><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-12">
                <h6 class="text-white fw-bold mb-4">Hubungi Kami</h6>
                <div class="d-flex mb-3 align-items-start">
                    <div class="contact-icon me-3"><i class="bi bi-geo-alt"></i></div>
                    <div class="small text-white-50">Jl. Merdeka No. 45, Dago, Bandung, Jawa Barat</div>
                </div>
                <div class="d-flex mb-3 align-items-start">
                    <div class="contact-icon me-3"><i class="bi bi-whatsapp"></i></div>
                    <div class="small text-white-50">+62 812-3456-7890</div>
                </div>
                <div class="d-flex mb-3 align-items-start">
                    <div class="contact-icon me-3"><i class="bi bi-envelope"></i></div>
                    <div class="small text-white-50">support@iqbaalstore.com</div>
                </div>
            </div>
        </div>

        <hr class="my-5 border-white opacity-10">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-white-50 mb-0 small">
                    &copy; {{ date('Y') }} <span class="text-white fw-bold">IqbaalStore</span>. Dibuat dengan <i class="bi bi-heart-fill text-danger mx-1"></i> Buat Kamu.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-4 mt-md-0">
                <div class="payment-methods text-white-50">
                    <i class="bi bi-credit-card-2-back fs-3 mx-2" title="Credit Card"></i>
                    <i class="bi bi-wallet2 fs-3 mx-2" title="E-Wallet"></i>
                    <i class="bi bi-bank fs-3 mx-2" title="Bank Transfer"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Paksa warna link footer agar muncul terang */
    .footer-links a {
        color: rgba(255, 255, 255, 0.6) !important;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .footer-links a:hover {
        color: #0d6efd !important;
        transform: translateX(5px);
    }

    .social-icon {
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.1);
        color: white !important;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .social-icon:hover {
        background: #0d6efd;
        color: white !important;
        transform: translateY(-5px);
    }

    .contact-icon {
        color: #0d6efd;
        font-size: 1.2rem;
        line-height: 1;
    }
</style>