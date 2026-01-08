<?php

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
        // 1. Ambil Statistik Utama
        $stats = [
            'total_revenue' => Order::whereIn('status', ['processing', 'completed'])->sum('total_amount'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->where('payment_status', 'paid')->count(),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ];

        // 2. Pesanan Terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // 3. Produk Terlaris (Eager Load primaryImage agar gambar muncul)
        $topProducts = Product::with(['primaryImage'])
            ->withCount(['orderItems as sold' => function ($q) {
                $q->select(DB::raw('SUM(quantity)'))
                  ->whereHas('order', function ($query) {
                      $query->where('payment_status', 'paid');
                  });
            }])
            ->orderByDesc('sold')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // 4. Data Grafik (7 Hari Terakhir)
        $revenueData = Order::select([
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total'),
        ])
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->pluck('total', 'date'); // Mengembalikan Collection [ '2024-01-01' => 50000 ]

        $chartCollection = collect();
        for ($i = 6; $i >= 0; --$i) {
            $dateKey = now()->subDays($i)->format('Y-m-d');
            $chartCollection->push([
                'date' => now()->subDays($i)->format('d M'),
                'total' => $revenueData[$dateKey] ?? 0,
            ]);
        }

        // Kirim $chartCollection yang merupakan Collection agar ->pluck() di Blade berfungsi
        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'revenueChart' => $chartCollection,
        ]);
    }
}
