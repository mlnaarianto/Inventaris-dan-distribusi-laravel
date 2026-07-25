<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequestDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_request_id', 'product_id', 'qty_diminta', 'keterangan_sistem'];


    // Relasi: Satu Detail dimiliki oleh Satu Produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
