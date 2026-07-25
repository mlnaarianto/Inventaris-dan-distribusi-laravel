<?php

namespace App\Http\Controllers\Pusat;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\StockMutation;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung statistik untuk Pusat
        $totalProduk = Product::count();
        $totalStok = Product::sum('stok_pusat');
        $requestPending = ProductRequest::where('status', 'pending')->count();
        $mutasiKeluar = StockMutation::where('jenis_mutasi', 'keluar')->count();

        return view('pusat.dashboard', compact('totalProduk', 'totalStok', 'requestPending', 'mutasiKeluar'));
    }
}
