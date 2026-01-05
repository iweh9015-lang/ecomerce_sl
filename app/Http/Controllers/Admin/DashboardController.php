<?php

// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama (Cards)
        // Kita menghitung data real-time dari database.
        // Konsep: Gunakan method agregat database (SUM, COUNT) daripada menarik data ke PHP (get() -> count()).
        // Alasan: Jauh lebih hemat memori server.

        $stats = [
            'total_revenue' => Order::whereIn('status', ['processing', 'completed'])
                                    ->sum('total_amount'), // SQL: SELECT SUM(total_amount) FROM orders WHERE ...

            'total_orders' => Order::count(), // SQL: SELECT COUNT(*) FROM orders

            // Pending Orders: Yang perlu tindakan segera admin
            'pending_orders' => Order::where('status', 'pending')
                                     ->where('payment_status', 'paid') // Sudah bayar tapi belum diproses
                                     ->count(),

            'total_products' => Product::count(),

            'total_customers' => User::where('role', 'customer')->count(),

            // Stok Rendah: Produk dengan stok <= 5
            // Berguna untuk notifikasi re-stock
            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ];

        // 2. Data Tabel Pesanan Terbaru (5 transaksi terakhir)
        // Eager load 'user' untuk menghindari N+1 Query Problem saat menampilkan nama customer di blade.
        $recentOrders = Order::with('user')
            ->latest() // alias orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Produk Terlaris
        // Tantangan: Menghitung total qty terjual dari tabel relasi (order_items)
        // Solusi: withCount dengan query modifikasi (SUM quantity)
        $topProducts = Product::withCount(['orderItems as sold' => function ($q) {
            // Kita hanya hitung item yang berasal dari order yang SUDAH DIBAYAR (paid)
            $q->select(DB::raw('SUM(quantity)'))
              ->whereHas('order', function ($query) {
                  $query->where('payment_status', 'paid');
              });
        }])
            ->having('sold', '>', 0) // Filter: Hanya tampilkan yang pernah terjual
            ->orderByDesc('sold')    // Urutkan dari yang paling laku
            ->take(5)
            ->get();

        // 4. Data Grafik Pendapatan (7 Hari Terakhir)
        // Kasus: Grouping data per tanggal
        // Kita gunakan DB::raw untuk format tanggal dari timestamp 'created_at'
        $revenueChart = Order::select([
            DB::raw('DATE(created_at) as date'), // Ambil tanggalnya saja (2024-12-10)
            DB::raw('SUM(total_amount) as total'), // Total omset hari itu
        ])
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(7)) // Filter 7 hari ke belakang
            ->groupBy('date') // Kelompokkan baris berdasarkan tanggal
            ->orderBy('date', 'asc') // Urutkan kronologis
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'revenueChart'));
    }
}
