<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // implementasi penyimpanan kategori
    }

    public function edit($id)
    {
        return view('admin.categories.edit');
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
