<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Daftarkan kolom apa saja yang BOLEH diisi melalui form (Mass Assignment)
    protected $fillable = [
        'nama_barang',
        'ukuran',
        'satuan',
        'stok_pusat',
        'stok_distributor',

        // TAMBAHAN REVISI: Izinkan kolom harga dan gambar untuk diisi
        'harga',
        'gambar',
    ];
}
