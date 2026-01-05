<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.partials.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.partials.navbar')
            <!--  Header End -->
            <div class="container-fluid">
                <!--  Row 1 -->
                @include('partials.flash-messages')
                @yield('content')
                <footer class="mt-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-4 px-4">
                            <div class="row align-items-center">

                                {{-- LEFT --}}
                                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                                    <span class="fw-semibold">
                                        <i class="bi bi-shop me-1 text-primary"></i>
                                        Iqbaal Store
                                    </span>
                                    <span class="text-muted">
                                        &copy; {{ date('Y') }}. All rights reserved.
                                    </span>
                                </div>

                                {{-- RIGHT --}}
                                <div class="col-md-6 text-center text-md-end">
                                    <span class="text-muted me-1">Designed & Developed by</span>
                                    <a href="https://kaceinspace.vercel.app" target="_blank"
                                        class="fw-semibold text-decoration-none text-primary">
                                        Kace
                                    </a>
                                    <i class="bi bi-box-arrow-up-right ms-1 text-primary"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/sidebarmenu.js')}}"></script>
    <script src="{{asset('assets/js/app.min.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    @stack('scripts')
</body>

</html>