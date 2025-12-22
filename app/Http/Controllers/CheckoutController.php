<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $orderService;
    protected $cartService;

    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        try {
            $order = $this->orderService->createOrder(
                auth()->user(),
                $request->only(['name', 'phone', 'address'])
            );

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silahkan lakukan pembayaran.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
