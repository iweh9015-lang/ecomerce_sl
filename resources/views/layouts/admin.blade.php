<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | Iqbaal Store</title>
    
    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: #f4f7fb;
        }
        
        /* Animasi Transisi Halaman */
        .page-content-fade {
            animation: fadeIn 0.4s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer Modern */
        .footer-premium {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1rem;
        }

        .dev-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .dev-link:hover {
            color: #0d6efd !important;
            letter-spacing: 0.5px;
        }

        /* Sidebar & Header adjustment */
        .body-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        
        @include('layouts.partials.sidebar')
        <div class="body-wrapper">
            @include('layouts.partials.navbar')
            <div class="container-fluid flex-grow-1">
                <div class="page-content-fade">
                    @include('partials.flash-messages')
                    
                    @yield('content')
                </div>

                {{-- FOOTER --}}
                <footer class="mt-5 mb-4">
                    <div class="footer-premium shadow-sm py-3 px-4">
                        <div class="row align-items-center">
                            {{-- LEFT --}}
                            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="bi bi-shop text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block" style="line-height: 1.2;">Iqbaal Store</span>
                                        <small class="text-muted">&copy; {{ date('Y') }} All rights reserved.</small>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT --}}
                            <div class="col-md-6 text-center text-md-end">
                                <small class="text-muted me-1">Crafted with</small>
                                <i class="bi bi-heart-fill text-danger small mx-1"></i>
                                <small class="text-muted">by</small>
                                <a href="https://iqbaal.vercel.app" target="_blank"
                                    class="fw-bold text-decoration-none text-dark dev-link ms-1">
                                    Iqbaal Dev
                                    <i class="bi bi-arrow-up-right-short small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    
    {{-- Global Script Enhancements --}}
    <script>
        $(function() {
            // Auto hide flash messages
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Active Menu Auto Scroll
            if ($('.sidebar-link.active').length > 0) {
                $('.left-sidebar').animate({
                    scrollTop: $('.sidebar-link.active').offset().top - 200
                }, 500);
            }
        });
    </script>
    
    @stack('scripts')
</body>

</html>