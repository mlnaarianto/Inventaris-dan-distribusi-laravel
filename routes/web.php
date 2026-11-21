<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pusat\ProductController;
use App\Http\Controllers\Pusat\RequestController as PusatRequestController;
use App\Http\Controllers\Pusat\StockPredictionController;
use App\Http\Controllers\Distributor\RequestController as DistributorRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 1. Dashboard tunggal (isi menyesuaikan permission di controller)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.view'])
    ->name('dashboard');


// 2. Ruang Kerja Khusus PUSAT (sementara, akan dibongkar di commit berikutnya)
Route::middleware(['auth', 'role:pusat|super-admin'])->prefix('pusat')->name('pusat.')->group(function () {

    // Rute CRUD Master Barang
    Route::resource('produk', ProductController::class);

    // Rute Tambahan untuk Cetak PDF Surat Jalan
    Route::get('request/{id}/cetak', [PusatRequestController::class, 'cetak'])->name('request.cetak');

    // Rute Validasi & Manajemen Request Masuk
    Route::resource('request', PusatRequestController::class);

    // Rute Laporan Kartu Stok / Mutasi
    Route::get('mutasi', [\App\Http\Controllers\Pusat\MutationController::class, 'index'])->name('mutasi.index');

    // Rute khusus untuk Update Status
    Route::put('request/{id}/update-status', [PusatRequestController::class, 'updateStatus'])->name('request.updateStatus');

    // Rute Prediksi Stok AI
    // Route::get('prediksi-stok', [StockPredictionController::class, 'index'])->name('prediksi.index');
    // Route::post('prediksi-stok', [StockPredictionController::class, 'predict'])->name('prediksi.predict');

});


// 3. Ruang Kerja Khusus DISTRIBUTOR (sementara, akan dibongkar di commit berikutnya)
Route::middleware(['auth', 'role:distributor'])->prefix('distributor')->name('distributor.')->group(function () {

    // Rute Pembuatan & Riwayat Request Barang
    Route::resource('request', DistributorRequestController::class);

});


// Rute Profil bawaan Laravel Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memanggil rute otentikasi (Login, Logout, dll) bawaan Breeze
require __DIR__.'/auth.php';