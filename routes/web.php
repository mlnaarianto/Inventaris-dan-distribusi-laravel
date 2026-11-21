<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard tunggal (isi menyesuaikan permission di controller)
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

// Katalog produk & riwayat mutasi
Route::middleware('auth')->group(function () {
    Route::get('/produk', [ProductController::class, 'index'])->middleware('permission:produk.view')->name('produk.index');
    Route::get('/produk/create', [ProductController::class, 'create'])->middleware('permission:produk.create')->name('produk.create');
    Route::post('/produk', [ProductController::class, 'store'])->middleware('permission:produk.create')->name('produk.store');
    Route::get('/produk/{produk}/edit', [ProductController::class, 'edit'])->middleware('permission:produk.update')->name('produk.edit');
    Route::put('/produk/{produk}', [ProductController::class, 'update'])->middleware('permission:produk.update')->name('produk.update');
    Route::delete('/produk/{produk}', [ProductController::class, 'destroy'])->middleware('permission:produk.delete')->name('produk.destroy');

    Route::get('/mutasi', [MutationController::class, 'index'])->middleware('permission:mutasi.view')->name('mutasi.index');
    Route::get('/mutasi/cetak', [MutationController::class, 'cetak'])->middleware('permission:mutasi.cetak')->name('mutasi.cetak');
});

// Rute Profil bawaan Laravel Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


Route::middleware('auth')->prefix('roles')->name('roles.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->middleware('permission:role.view')->name('index');
    Route::get('/create', [RoleController::class, 'create'])->middleware('permission:role.create')->name('create');
    Route::post('/', [RoleController::class, 'store'])->middleware('permission:role.create')->name('store');
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:role.update')->name('edit');
    Route::put('/{role}', [RoleController::class, 'update'])->middleware('permission:role.update')->name('update');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:role.delete')->name('destroy');

    Route::get('/{role}/permissions', [RolePermissionController::class, 'edit'])->middleware('permission:role.permission')->name('permissions.edit');
    Route::put('/{role}/permissions', [RolePermissionController::class, 'update'])->middleware('permission:role.permission')->name('permissions.update');
});


Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->middleware('permission:user.view')->name('index');
    Route::get('/create', [UserController::class, 'create'])->middleware('permission:user.create')->name('create');
    Route::post('/', [UserController::class, 'store'])->middleware('permission:user.create')->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->middleware('permission:user.update')->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:user.update')->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:user.delete')->name('destroy');

    Route::get('/{user}/password', [UserController::class, 'editPassword'])->middleware('permission:user.reset-password')->name('password.edit');
    Route::put('/{user}/password', [UserController::class, 'updatePassword'])->middleware('permission:user.reset-password')->name('password.update');
});

// Rute otentikasi (Login, Logout, dll) bawaan Breeze
require __DIR__ . '/auth.php';
