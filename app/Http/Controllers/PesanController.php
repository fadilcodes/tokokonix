<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Auth;
use Carbon\Carbon;
use Alert; // Kalau lu pake SweetAlert, kalo enggak hapus aja

class PesanController extends Controller
{

    public function index($id)
    {
        // Cari barang berdasarkan ID
        $barang = Barang::where('id', $id)->first();

        // Oper data barang ke View. 
        // Pastikan nama file blade lu adalah 'pesan.blade.php' di folder views.
        // Kalau nama filenya beda (misal: detail_barang.blade.php), ganti 'pesan' jadi 'detail_barang'
        return view('pesan', compact('barang'));
    }


    public function pesan(Request $request, $id)
    {
        $barang = Barang::where('id', $id)->first();
        $tanggal = Carbon::now();

        // 1. Validasi: Pastikan stok cukup
        if($request->quantity > $barang->stok) {
            return redirect('pesan/'.$id); // Bisa ditambahin pesan error
        }

        // 2. Validasi: Pastikan ukuran dipilih
        if (empty($request->ukuran)) {
            return redirect('pesan/'.$id); // Bisa ditambahin pesan "Pilih ukuran dulu bro!"
        }

        // 3. Cek apakah user punya keranjang (Pesanan) yang belum dibayar (status 0)
        $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)
                                ->where('status', 0)->first();

        // Kalau belum ada keranjang, kita buat baru (Parent-nya)
        if(empty($cek_pesanan))
        {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->kode = mt_rand(100, 999); // Kode unik
            $pesanan->save();
        }

        // 4. Simpan ke Pesanan Detail (Isinya barang yang dibeli)
        
        // Ambil ID pesanan yang aktif
        $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)
                                 ->where('status', 0)->first();

        // Cek apakah barang ini DENGAN UKURAN INI udah ada di keranjang?
        // Note: Kita cek barang_id DAN ukuran. Jadi kalau beli S lalu beli L, dianggap beda baris.
        $cek_pesanan_detail = PesananDetail::where('barang_id', $barang->id)
                                            ->where('pesanan_id', $pesanan_baru->id)
                                            ->where('ukuran', $request->ukuran) 
                                            ->first();

        if(empty($cek_pesanan_detail)) 
        {
            // Kalau barang belum ada, buat baris baru
            $pesanan_detail = new PesananDetail;
            $pesanan_detail->barang_id = $barang->id;
            $pesanan_detail->pesanan_id = $pesanan_baru->id;
            $pesanan_detail->ukuran = $request->ukuran; // <--- INI KOLOM BARU LU
            $pesanan_detail->jumlah = $request->quantity;
            $pesanan_detail->jumlah_harga = $barang->harga * $request->quantity;
            $pesanan_detail->save();
        } else {
            // Kalau barang & ukuran sama udah ada, update jumlahnya aja
            $cek_pesanan_detail->jumlah = $cek_pesanan_detail->jumlah + $request->quantity;
            
            // Harga baru = harga sekarang + (harga satuan * qty baru)
            $harga_pesanan_detail_baru = $barang->harga * $request->quantity;
            $cek_pesanan_detail->jumlah_harga = $cek_pesanan_detail->jumlah_harga + $harga_pesanan_detail_baru;
            $cek_pesanan_detail->update();
        }

        // 5. Update Total Harga di Tabel Pesanan (Parent)
        $pesanan_baru->jumlah_harga = $pesanan_baru->jumlah_harga + ($barang->harga * $request->quantity);
        $pesanan_baru->update();

        // 6. Redirect langsung ke halaman checkout
        return redirect('checkout/'.$pesanan_baru->id);
    }

    public function checkout($id)
    {
        // $pesanan = Pesanan::find($id);
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $snapToken = null;
        
        // Ambil detail biar bisa ditampilin list barangnya apa aja
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        
        // --- KONFIGURASI MIDTRANS ---
        // Set konfigurasi midtrans
        if (!empty($pesanan) && $pesanan->jumlah_harga > 0) {
            
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Buat params yang dikirim ke Midtrans
        $params = array(
        'transaction_details' => array(
            'order_id' => $pesanan->kode . '-' . time(),
            'gross_amount' => $pesanan->jumlah_harga, // <-- INI GAK BOLEH 0
        ),
        'customer_details' => array(
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->nohp ?? '',
        ),
    );

        try {
        $snapToken = Snap::getSnapToken($params);
    } catch (\Exception $e) {
        // Kalau error koneksi, biarin null atau log errornya
        $snapToken = null; 
    }
}
        
        // Kirim $snapToken ke View
        return view('checkout', compact('pesanan', 'pesanan_details', 'snapToken'));
    }

    public function delete($id)
    {
        $pesanan_detail = PesananDetail::find($id);
        
        // Ambil Pesanan Utama (Parent)
        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();

        // Update Total Harga Utama (Kurangi dengan harga total barang yang dihapus)
        $pesanan->jumlah_harga = $pesanan->jumlah_harga - $pesanan_detail->jumlah_harga;
        $pesanan->update();

        // Hapus datanya
        $pesanan_detail->delete();

        // Balikin ke halaman checkout
        return redirect('checkout/'.$pesanan->id)->with('success', 'Barang berhasil dihapus!');
    }

    public function konfirmasi_kurang($id)
    {
        $pesanan_detail = PesananDetail::find($id);
        $barang = Barang::where('id', $pesanan_detail->barang_id)->first();
        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();

        // Cek: Kalau jumlahnya lebih dari 1, baru bisa dikurangin
        if($pesanan_detail->jumlah > 1) {
            
            // Kurangi jumlah detail
            $pesanan_detail->jumlah = $pesanan_detail->jumlah - 1;
            // Update harga total per item ini
            $pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga - $barang->harga;
            $pesanan_detail->update();

            // Kurangi Total Harga Utama
            $pesanan->jumlah_harga = $pesanan->jumlah_harga - $barang->harga;
            $pesanan->update();
        }

        return redirect('checkout/'.$pesanan->id);
    }

    public function konfirmasi_tambah($id)
    {
        $pesanan_detail = PesananDetail::find($id);
        $barang = Barang::where('id', $pesanan_detail->barang_id)->first();
        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();

        // Cek stok dulu, jangan sampe beli melebihi stok
        if($pesanan_detail->jumlah < $barang->stok) {
            
            $pesanan_detail->jumlah = $pesanan_detail->jumlah + 1;
            $pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga + $barang->harga;
            $pesanan_detail->update();

            $pesanan->jumlah_harga = $pesanan->jumlah_harga + $barang->harga;
            $pesanan->update();
        }

        return redirect('checkout/'.$pesanan->id);
    }


    public function payment_finish(Request $request)
    {
        $order_id = $request->order_id; // Isinya misal: 593-170332111
        $status_code = $request->status_code;
        $transaction_status = $request->transaction_status;

        // --- KONFIGURASI MIDTRANS ---
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Cek status ke Midtrans
        $status = Transaction::status($order_id);
        
        // --- LOGIC BARU: MEMECAH ORDER ID ---
        // Karena formatnya KODE-WAKTU, kita pecah pake explode
        $pecah_order_id = explode('-', $order_id); 
        $kode_pesanan_asli = $pecah_order_id[0]; // Kita ambil angka depannya aja (593)

        // Cari Pesanan berdasarkan KODE ASLI
        $pesanan = Pesanan::where('kode', $kode_pesanan_asli)->first();
        
        // Cek Status Transaksi
        if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
            
            // UPDATE DATABASE
            $pesanan->status = 1; 
            $pesanan->update();
            
            return view('payment_success', compact('pesanan'));
            
        } else {
            return redirect('checkout/'.$pesanan->id)->with('alert', 'Pembayaran belum selesai atau gagal.');
        }
    }
    

}