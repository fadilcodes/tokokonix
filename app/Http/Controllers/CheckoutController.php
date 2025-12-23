<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CheckoutController extends Controller
{

    public function index($id)
    {
        $barang = Barang::where('id', $id)->firstOrFail();
        return view('checkout', compact('barang'));
    }
}