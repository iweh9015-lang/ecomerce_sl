<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        return view('admin.orders.pay', compact('order'));
    }

    public function success(Order $order)
    {
        return view('admin.orders.success', compact('order'));
    }

    public function pending(Order $order)
    {
        return view('admin.orders.pending', compact('order'));
    }
}
