<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pusat\ProductController;
use App\Http\Controllers\Pusat\RequestController as PusatRequestController;
use App\Http\Controllers\Distributor\RequestController as DistributorRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pusat\DashboardController as PusatDashboardController;
use App\Http\Controllers\Distributor\DashboardController as DistributorDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman awal / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 1. Pengaturan Pengalihan (Redirect) Otomatis setelah Login
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'pusat') {
        return redirect()->route('pusat.dashboard');
    }
    return redirect()->route('distributor.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 2. Ruang Kerja Khusus PUSAT (Admin Pusat Pocari)
Route::middleware(['auth', 'role:pusat'])->prefix('pusat')->name('pusat.')->group(function () {

    // Dashboard pusat otomatis dialihkan ke halaman produk
    // Ubah rute dashboard ini
    Route::get('/dashboard', [PusatDashboardController::class, 'index'])->name('dashboard');

    // Rute CRUD Master Barang
    Route::resource('produk', ProductController::class);

    // Rute Tambahan untuk Cetak PDF Surat Jalan
    Route::get('request/{id}/cetak', [PusatRequestController::class, 'cetak'])->name('request.cetak');

    // Rute Validasi & Manajemen Request Masuk
    Route::resource('request', PusatRequestController::class);

    // Rute Laporan Kartu Stok / Mutasi
    Route::get('mutasi', [\App\Http\Controllers\Pusat\MutationController::class, 'index'])->name('mutasi.index');

    // TAMBAHKAN BARIS INI (Rute khusus untuk Update Status)
    Route::put('request/{id}/update-status', [PusatRequestController::class, 'updateStatus'])->name('request.updateStatus');


});


// 3. Ruang Kerja Khusus DISTRIBUTOR
Route::middleware(['auth', 'role:distributor'])->prefix('distributor')->name('distributor.')->group(function () {

    // Dashboard distributor otomatis dialihkan ke halaman request
    Route::get('/dashboard', [DistributorDashboardController::class, 'index'])->name('dashboard');

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
