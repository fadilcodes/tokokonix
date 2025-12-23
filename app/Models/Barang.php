<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Pastikan nama tabel di DB lu 'barangs' (default laravel) 
    // atau tambahin: protected $table = 'nama_tabel_lu';

    public function pesanan_detail() {
        // Perbaiki path jadi backslash \
        return $this->hasMany('App\Models\PesananDetail', 'barang_id', 'id');
    }
}