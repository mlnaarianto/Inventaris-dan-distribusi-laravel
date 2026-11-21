<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\StockMutation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $viewAll      = $user->can('request.view-all');    // cakupan data
        $dashboardAll = $user->can('dashboard.view-all');  // tampilan dashboard pusat

        // Yang punya request.view-all melihat semua order, selain itu hanya miliknya sendiri
        $scope = fn ($query) => $viewAll ? $query : $query->where('user_id', $user->id);

        $perStatus = $scope(ProductRequest::query())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stat = [
            'total'    => (int) $perStatus->sum(),
            'pending'  => (int) ($perStatus['pending'] ?? 0),
            'diproses' => (int) ($perStatus['diproses'] ?? 0),
            'dikirim'  => (int) ($perStatus['dikirim'] ?? 0),
            'selesai'  => (int) ($perStatus['selesai'] ?? 0),
        ];

        $recentRequests = $scope(ProductRequest::with(['user', 'details']))
            ->latest()
            ->take(5)
            ->get();

        // Statistik gudang hanya untuk yang punya dashboard.view-all
        $gudang = $dashboardAll ? [
            'totalProduk'  => Product::count(),
            'totalStok'    => (int) Product::sum('stok_pusat'),
            'mutasiKeluar' => StockMutation::where('jenis_mutasi', 'keluar')->count(),
        ] : null;

        return view('dashboard', compact('viewAll', 'dashboardAll', 'stat', 'recentRequests', 'gudang'));
    }
}