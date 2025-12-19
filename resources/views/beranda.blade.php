@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="relative min-h-screen flex items-center justify-center px-4
                bg-gradient-to-br from-[#f5f9ff] via-[#eef3ff] to-white overflow-hidden">

    {{-- Background Orbs --}}
    <div class="absolute -top-48 -left-48 w-[36rem] h-[36rem] bg-blue-400/30 rounded-full blur-[120px]"></div>
    <div class="absolute -bottom-48 -right-48 w-[36rem] h-[36rem] bg-indigo-400/30 rounded-full blur-[120px]"></div>

    {{-- Hero Card --}}
    <div class="relative z-10 w-full max-w-5xl">
        <div class="relative bg-white/80 backdrop-blur-2xl rounded-[2.5rem]
                    shadow-[0_40px_120px_-30px_rgba(0,0,0,0.25)]
                    px-10 py-20 text-center">

            {{-- Top Badge --}}
            <div class="inline-flex items-center gap-2 px-5 py-2.5 mb-8
                        bg-gradient-to-r from-blue-100 to-indigo-100
                        text-blue-700 rounded-full text-sm font-semibold shadow">
                ⭐ E-Commerce Terpercaya di Indonesia
            </div>

            {{-- Title --}}
            <h1 class="text-5xl md:text-7xl font-black leading-tight tracking-tight
                       text-transparent bg-clip-text
                       bg-gradient-to-r from-blue-700 via-indigo-600 to-purple-600">
                Belanja Lebih <br class="hidden sm:block">
                <span class="text-slate-900">Mudah & Aman</span>
            </h1>

            {{-- Subtitle --}}
            <p class="mt-8 text-xl text-slate-600 max-w-3xl mx-auto">
                TokoIqbaal menghadirkan produk pilihan, harga bersahabat,
                dan pengalaman belanja yang cepat serta nyaman.
            </p>

            {{-- Clock & Weather --}}
            <div class="flex flex-col sm:flex-row justify-center gap-6 mt-14">

                <div class="flex items-center gap-3 px-7 py-4 rounded-2xl
                            bg-white shadow-lg text-blue-700
                            font-mono text-2xl">
                    ⏰ <span id="digital-clock">--:--:--</span>
                </div>

                <div class="flex items-center gap-3 px-7 py-4 rounded-2xl
                            bg-white shadow-lg text-slate-700">
                    <img id="weather-icon" class="w-9 h-9" alt="">
                    <span id="weather-info">Memuat cuaca...</span>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="mt-16 flex flex-col sm:flex-row justify-center gap-8">

                <a href="{{ route('catalog.index') }}"
                   class="group relative px-12 py-5 rounded-2xl
                          bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600
                          text-white font-bold text-lg shadow-xl
                          hover:shadow-[0_20px_60px_rgba(79,70,229,0.6)]
                          hover:scale-110 transition-all duration-300">

                    <span class="relative z-10 flex items-center gap-3">
                        🛒 Mulai Belanja
                        <span class="group-hover:translate-x-1 transition">→</span>
                    </span>

                    {{-- Glow --}}
                    <span class="absolute inset-0 rounded-2xl blur-xl
                                 bg-gradient-to-r from-blue-500 to-purple-500
                                 opacity-0 group-hover:opacity-60 transition"></span>
                </a>

                <a href="{{ route('profile.index') }}"
                   class="group px-12 py-5 rounded-2xl font-bold text-lg
                          bg-white text-slate-800 shadow-lg
                          border border-slate-200
                          hover:border-blue-500 hover:text-blue-700
                          hover:scale-110 transition-all duration-300">

                    <span class="flex items-center gap-3">
                        👤 Ke Profil
                        <span class="group-hover:translate-x-1 transition">→</span>
                    </span>
                </a>

            </div>

            {{-- Features --}}
            <div class="mt-24 grid grid-cols-1 sm:grid-cols-3 gap-8 text-left">

                <div class="p-8 rounded-3xl bg-white shadow-lg
                            hover:shadow-2xl hover:-translate-y-2 transition">
                    <h3 class="font-bold text-xl mb-3">🚚 Pengiriman Cepat</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Sistem logistik modern memastikan produk sampai tepat waktu.
                    </p>
                </div>

                <div class="p-8 rounded-3xl bg-white shadow-lg
                            hover:shadow-2xl hover:-translate-y-2 transition">
                    <h3 class="font-bold text-xl mb-3">💳 Pembayaran Aman</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Mendukung berbagai metode pembayaran yang aman dan terpercaya.
                    </p>
                </div>

                <div class="p-8 rounded-3xl bg-white shadow-lg
                            hover:shadow-2xl hover:-translate-y-2 transition">
                    <h3 class="font-bold text-xl mb-3">⭐ Produk Berkualitas</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Semua produk telah dikurasi untuk menjamin kualitas terbaik.
                    </p>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function updateClock() {
    document.getElementById('digital-clock')
        .textContent = new Date().toLocaleTimeString('id-ID');
}
setInterval(updateClock, 1000);
updateClock();

// Weather
async function loadWeather() {
    const apiKey = '';
    if (!apiKey) {
        document.getElementById('weather-info').textContent = 'Cuaca tidak tersedia';
        return;
    }

    try {
        const res = await fetch(
            `https://api.openweathermap.org/data/2.5/weather?q=Jakarta&units=metric&lang=id&appid=${apiKey}`
        );
        const data = await res.json();
        document.getElementById('weather-info').textContent =
            `${Math.round(data.main.temp)}°C, ${data.weather[0].description}`;
        document.getElementById('weather-icon').src =
            `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`;
    } catch {
        document.getElementById('weather-info').textContent = 'Gagal memuat cuaca';
    }
}
loadWeather();
</script>
@endpush
