<?php

namespace App\Http\Controllers\Pusat;

use App\Http\Controllers\Controller;
use App\Models\StockMutation;

class MutationController extends Controller
{
    public function index()
    {
        // Ambil semua data mutasi stok diurutkan dari yang paling baru
        $mutasi = StockMutation::with('product')->orderBy('created_at', 'desc')->get();
        return view('pusat.mutasi.index', compact('mutasi'));
    }
}
