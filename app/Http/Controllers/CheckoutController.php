<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        if (view()->exists('checkout.index')) {
            return view('checkout.index');
        }

        return response()->view('errors.simple', ['message' => 'Checkout page not implemented.'], 200);
    }

    public function store(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Checkout processed (dummy).'], 200);
    }
}
