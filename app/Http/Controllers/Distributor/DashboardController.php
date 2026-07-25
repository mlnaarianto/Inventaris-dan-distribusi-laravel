<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung statistik untuk Distributor
        $totalStok = Product::sum('stok_distributor');
        $requestPending = ProductRequest::where('status', 'pending')->count();
        $requestDikirim = ProductRequest::where('status', 'dikirim')->count();
        $requestSelesai = ProductRequest::where('status', 'selesai')->count();

        return view('distributor.dashboard', compact('totalStok', 'requestPending', 'requestDikirim', 'requestSelesai'));
    }
}
