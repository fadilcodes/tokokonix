<?php

namespace App\Http\Controllers;

use App\Models\Barang; // 1. Import model Barang
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()

    {
    // $barangs = Barang::where('kategori', 'celana', 'baju')->get();
    $barangs = Barang::all();
    return view('product', compact('barangs'));
}
}