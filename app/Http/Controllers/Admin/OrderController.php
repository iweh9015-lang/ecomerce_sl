<?php

// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     * Dilengkapi filter by status.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user') // N+1 prevention: Load data user pemilik order
            // Fitur Filter Status (?status=pending)
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest() // Urutkan terbaru
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        // Load item produk dan data user
        $order->load(['items.product', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (misal: kirim barang)
     * Handle otomatis pengembalian stok jika status diubah jadi Cancelled.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi status yang dikirim form
        $request->validate([
            'status' => 'required|in:processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // ============================================================
        // LOGIKA RESTOCK (PENTING!)
        // ============================================================
        // Jika admin membatalkan pesanan, stok barang harus dikembalikan ke gudang.
        // Syarat:
        // 1. Status baru adalah 'cancelled'
        // 2. Status lama BUKAN 'cancelled' (agar tidak restock 2x kalau tombol ditekan berkali-kali)
        // ============================================================
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                // increment() adalah operasi atomik (thread-safe) di level database.
                // SQL-nya kurang lebih: UPDATE products SET stock = stock + X WHERE id = Y
                // Ini aman dari Race Condition jika ada transaksi bersamaan.
                $item->product->increment('stock', $item->quantity);
            }
        }

        // Update status di database
        $order->update(['status' => $newStatus]);

        return back()->with('success', "Status pesanan diperbarui menjadi $newStatus");
    }
}
