<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan user yang statusnya BUKAN 0 (artinya udah checkout/lunas)
        $pesanans = Pesanan::where('user_id', Auth::user()->id)
                            ->where('status', '!=', 0) 
                            ->orderBy('tanggal', 'desc') // Yang terbaru paling atas
                            ->get();

        return view('history.index', compact('pesanans'));
    }

    public function detail($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        return view('history.detail', compact('pesanan', 'pesanan_details'));
    }
}