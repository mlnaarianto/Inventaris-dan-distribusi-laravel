<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    // Tambahkan user_id di sini
    protected $fillable = ['user_id', 'kode_request', 'tanggal_request', 'status'];

    // Relasi ke User (Distributor pemesan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi: Satu Request memiliki Banyak Detail
    public function details()
    {
        return $this->hasMany(ProductRequestDetail::class, 'product_request_id', 'id');
    }
}
