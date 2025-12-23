<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    // Arahkan ke tabel yang bener
    protected $table = 'pesanan_details';

    // Sesuaikan sama nama kolom di Database & Controller
    protected $fillable = [
        'barang_id', 
        'pesanan_id', 
        'jumlah', 
        'jumlah_harga', 
        'ukuran' // <--- Ini yang baru kita tambah
    ];

    // Relasi ke Barang
    public function barang() {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }

    // Relasi ke Pesanan (Parent)
    public function pesanan() {
        return $this->belongsTo('App\Models\Pesanan', 'pesanan_id', 'id');
    }
}