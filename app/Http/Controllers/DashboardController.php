<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\StockMutation;

class DashboardController extends Controller
{
    public function index()
    {
        // Yang punya akses kelola produk = sisi pusat (super-admin otomatis lolos Gate::before)
        if (auth()->user()->can('produk.view')) {
            return $this->pusat();
        }

        return $this->distributor();
    }

    private function pusat()
    {
        $totalProduk = Product::count();
        $totalStok = Product::sum('stok_pusat');
        $requestPending = ProductRequest::where('status', 'pending')->count();
        $mutasiKeluar = StockMutation::where('jenis_mutasi', 'keluar')->count();

        return view('pusat.dashboard', compact('totalProduk', 'totalStok', 'requestPending', 'mutasiKeluar'));
    }

    private function distributor()
    {
        $totalStok = Product::sum('stok_distributor');
        $requestPending = ProductRequest::where('status', 'pending')->count();
        $requestDikirim = ProductRequest::where('status', 'dikirim')->count();
        $requestSelesai = ProductRequest::where('status', 'selesai')->count();

        return view('distributor.dashboard', compact('totalStok', 'requestPending', 'requestDikirim', 'requestSelesai'));
    }
}