@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

            <!-- PAGE TITLE -->
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-2 text-lg">Selamat datang kembali! Berikut adalah ringkasan data aplikasi Anda.
                </p>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

                <!-- USERS CARD -->
                <div
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" data-count="120">0</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a6 6 0 00-6-6 6 6 0 00-6 6z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-600 text-sm mt-4">↑ 12% dari bulan lalu</p>
                </div>

                <!-- ORDERS CARD -->
                <div
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" data-count="75">0</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-600 text-sm mt-4">↑ 8% dari bulan lalu</p>
                </div>

                <!-- REVENUE CARD -->
                <div
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Revenue</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" data-count="8500000">Rp 0</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-600 text-sm mt-4">↑ 25% dari bulan lalu</p>
                </div>

            </div>

            <!-- RECENT ACTIVITY CARD -->
            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Aktivitas Terbaru
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">User</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Aktivitas</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            A</div>
                                        <span class="ml-3 font-medium text-gray-900">Admin</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-600">Menambahkan produk baru</td>
                                <td class="py-4 px-4 text-gray-600">Hari ini, 10:30 AM</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Selesai</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            U</div>
                                        <span class="ml-3 font-medium text-gray-900">User01</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-600">Melakukan order</td>
                                <td class="py-4 px-4 text-gray-600">Kemarin, 03:45 PM</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Pending</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            U</div>
                                        <span class="ml-3 font-medium text-gray-900">User02</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-600">Update profil</td>
                                <td class="py-4 px-4 text-gray-600">2 hari lalu, 08:20 AM</td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Selesai</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="#"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                        Lihat Semua Aktivitas
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection
