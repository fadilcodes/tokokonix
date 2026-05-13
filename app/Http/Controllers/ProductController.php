<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Kalo lu mau nampilin spesifik kategori, pake whereIn kayak gini:
        // $barangs = Barang::whereIn('kategori', ['Baju', 'Celana'])->get();
        
        $barangs = Barang::all();
        return view('product', compact('barangs'));
    }

    public function create()
    {
        return view('product_upload');
    }

    public function store(Request $request)
    {
        // 1. Ubah 'keterangan' jadi 'kategori' biar sesuai sama database
        $request->validate([
            'nama_barang' => 'required',
            'kategori'    => 'required', // Tambahin ini
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Proses upload gambar ke folder public/uploads
        $file = $request->file('gambar');
        $nama_file = time() . "_" . $file->getClientOriginalName();
        $tujuan_upload = 'uploads';
        $file->move($tujuan_upload, $nama_file);

        // 3. Simpan data ke database
        $barang = new Barang();
        $barang->fill($request->all()); 
        $barang->gambar = $nama_file; // Timpa nama file gambar dengan yang udah di-rename
        $barang->save();

        return redirect('/product')->with('success', 'Produk berhasil ditambahkan!');
    }
}