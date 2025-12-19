@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <div
        class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8
               transition-all duration-500 ease-out hover:shadow-xl">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">
                Edit Profil
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                Perbarui data akun kamu di bawah ini
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Contoh: Ikbal Alim Mujiawan"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5
                           text-gray-800 placeholder-gray-400
                           focus:border-gray-800 focus:ring-1 focus:ring-gray-800
                           transition duration-300"
                >

                <p class="text-xs text-gray-400">
                    Gunakan nama asli agar mudah dikenali
                </p>

                @error('name')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    placeholder="contoh@email.com"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5
                           text-gray-800 placeholder-gray-400
                           focus:border-gray-800 focus:ring-1 focus:ring-gray-800
                           transition duration-300"
                >

                <p class="text-xs text-gray-400">
                    Email ini digunakan untuk login dan notifikasi
                </p>

                @error('email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Simpan --}}
            <button
                type="submit"
                class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold
                       transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]
                       hover:bg-gray-800 hover:shadow-lg hover:-translate-y-0.5
                       active:scale-[0.97]"
            >
                💾 Simpan Perubahan
            </button>
        </form>

        {{-- Divider --}}
        <div class="my-6 flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400">atau</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        {{-- Aksi Bawah --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('profile.index') }}"
               class="text-sm text-red-500 hover:text-gray-900 transition">
                ← Kembali
            </a>

            <a href="{{ route('catalog.index') }}"
               class="text-sm bg-blue-600 text-white px-4 py-2 rounded-lg
                      transition-all duration-300
                      hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5
                      active:scale-95">
                🛒 Ke Katalog
            </a>
        </div>

    </div>

</div>
@endsection
