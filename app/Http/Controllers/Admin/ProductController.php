<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // implementasi penyimpanan
    }

    public function show($id)
    {
        return view('admin.products.show');
    }

    public function edit($id)
    {
        return view('admin.products.edit');
    }

    public function update(Request $request, $id)
    {
        // implementasi update
    }

    public function destroy($id)
    {
        // implementasi hapus
    }
}
