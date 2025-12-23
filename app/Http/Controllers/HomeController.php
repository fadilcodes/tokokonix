<?php

namespace App\Http\Controllers;

use App\Models\barang; // 1. Import model Barang
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil data produk yang is_promo = true (yang lagi Flash Sale)
        $barangs = barang::where('is_promo', true) // 2. Gunakan nama model yang benar
                            ->limit(4) // Batasi cuma 3 produk aja (sesuai layout lu)
                            ->get();

        // 2. Kirim data itu ke file view 'home'
        return view('home', [
            'barangs' => $barangs
        ]);
    }
}
