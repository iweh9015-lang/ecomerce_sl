<?php

namespace App\Http\Controllers;

class OrderController extends Controller
{
    public function index()
    {
        if (view()->exists('orders.index')) {
            return view('orders.index');
        }

        return response()->view('errors.simple', ['message' => 'Orders page not implemented.'], 200);
    }

    public function show($order)
    {
        if (view()->exists('orders.show')) {
            return view('orders.show');
        }

        return response()->view('errors.simple', ['message' => 'Order detail not implemented.'], 200);
    }
}
