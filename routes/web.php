<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\Pusat\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman awal / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard tunggal
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard.view'])
    ->name('dashboard');

// Request barang (pusat & distributor, dibedakan lewat permission)
Route::middleware('auth')
    ->controller(RequestController::class)
    ->prefix('request')
    ->name('request.')
    ->group(function () {
        Route::get('/', 'index')->middleware('permission:request.view')->name('index');
        Route::get('/create', 'create')->middleware('permission:request.create')->name('create');
        Route::post('/', 'store')->middleware('permission:request.create')->name('store');
        Route::get('/{id}', 'show')->middleware('permission:request.view')->name('show');
        Route::get('/{id}/cetak', 'cetak')->middleware('permission:request.cetak')->name('cetak');
        Route::put('/{id}/status', 'updateStatus')->middleware('permission:request.update-status')->name('updateStatus');
        Route::put('/{id}/terima', 'terima')->middleware('permission:request.terima')->name('terima');
    });

// Sisa ruang kerja PUSAT (sementara, dibongkar di commit berikutnya)
Route::middleware(['auth', 'role:pusat|super-admin'])->prefix('pusat')->name('pusat.')->group(function () {

    Route::resource('produk', ProductController::class);

    Route::get('mutasi', [\App\Http\Controllers\Pusat\MutationController::class, 'index'])->name('mutasi.index');

    // Rute Prediksi Stok AI
    // Route::get('prediksi-stok', [StockPredictionController::class, 'index'])->name('prediksi.index');
    // Route::post('prediksi-stok', [StockPredictionController::class, 'predict'])->name('prediksi.predict');
});

// Rute Profil bawaan Laravel Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';