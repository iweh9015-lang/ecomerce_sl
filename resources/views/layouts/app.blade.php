<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    {{-- Animate.css untuk efek transisi antar halaman --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-blue: #2563eb;
            --dark-blue: #1e3a8a;
            --soft-blue: #eff6ff;
            --glass-white: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Custom Scrollbar agar terlihat Modern */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-blue);
        }

        /* Highlight Text Color */
        ::selection {
            background: var(--primary-blue);
            color: white;
        }

        /* Utility untuk Judul Tebal */
        .fw-black { font-weight: 800; }

        /* Styling Global untuk Badge Wishlist */
        #wishlist-count {
            background-color: #ef4444;
            color: white;
            font-size: 0.65rem;
            padding: 0.25em 0.6em;
            border: 2px solid white;
        }

        /* Loading Bar (Opsional) */
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary-blue);
            z-index: 9999;
            display: none;
        }
    </style>

    {{-- CSS tambahan per halaman --}}
    @stack('styles')
</head>

<body>
    <div id="page-loader"></div>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- FLASH MESSAGE --}}
    <div class="container mt-3 animate__animated animate__fadeIn">
        @include('partials.flash-messages')
    </div>

    {{-- MAIN CONTENT --}}
    <main class="min-vh-100 animate__animated animate__fadeIn">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- JS tambahan per halaman --}}
    @stack('scripts')

    <script>
        /**
         * Efek Progress Bar saat berpindah halaman
         */
        window.onbeforeunload = function() {
            document.getElementById('page-loader').style.display = 'block';
        };

        /**
         * Toggle Wishlist (Fetch API) dengan UI yang lebih halus
         */
        async function toggleWishlist(productId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                });

                if (response.status === 401) {
                    window.location.href = "/login";
                    return;
                }

                const data = await response.json();

                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                    // Gunakan notifikasi kecil di pojok daripada alert jika memungkinkan
                    console.log(data.message); 
                }
            } catch (error) {
                console.error("Wishlist Error:", error);
            }
        }

        function updateWishlistUI(productId, isAdded) {
            const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);

            buttons.forEach(btn => {
                const icon = btn.querySelector("i");
                if (!icon) return;

                // Animasi klik
                btn.classList.add('animate__animated', 'animate__heartBeat');
                setTimeout(() => btn.classList.remove('animate__heartBeat'), 500);

                if (isAdded) {
                    icon.classList.replace("bi-heart", "bi-heart-fill");
                    icon.classList.add("text-danger");
                    icon.classList.remove("text-secondary");
                } else {
                    icon.classList.replace("bi-heart-fill", "bi-heart");
                    icon.classList.remove("text-danger");
                    icon.classList.add("text-secondary");
                }
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                badge.style.display = count > 0 ? "inline-block" : "none";
                // Animasi angka naik
                badge.classList.add('animate__animated', 'animate__bounceIn');
                setTimeout(() => badge.classList.remove('animate__bounceIn'), 500);
            }
        }
    </script>
</body>
</html>