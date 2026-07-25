<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;

    // Daftarkan semua kolom tabel stock_mutations yang boleh diisi dari sistem
    protected $fillable = [
        'product_id',
        'jenis_mutasi',
        'qty',
        'tanggal',
        'keterangan',
    ];

    // Relasi opsional: Menghubungkan mutasi kembali ke data produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
