<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans'; // Biasanya laravel otomatis, tapi kita tembak aja biar aman

    protected $fillable = [
        'user_id',
        'tanggal',
        'status',
        'kode',
        'jumlah_harga'
    ];

    // Relasi ke User (Pembeli)
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // Relasi ke Detail (Barang apa aja yang dibeli)
    public function pesanan_details() {
        return $this->hasMany('App\Models\PesananDetail', 'pesanan_id', 'id');
    }
}