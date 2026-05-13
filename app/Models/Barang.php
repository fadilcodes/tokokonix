<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Daftarin kolom yang diizinin buat diisi massal dari form
    protected $fillable = [
        'nama_barang', 
        'kategori', 
        'harga', 
        'stok', 
        'gambar'
    ];

    public function pesanan_detail() {
        // Path pake backslash udah bener
        // Fyi aja: di Laravel versi baru biasanya ditulis gini biar lebih clean:
        // return $this->hasMany(PesananDetail::class, 'barang_id', 'id');
        
        return $this->hasMany('App\Models\PesananDetail', 'barang_id', 'id');
    }
}