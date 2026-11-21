<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

// Akun dibuat internal oleh administrator: tidak ada register publik
// dan tidak ada reset password lewat email.
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Ganti password dari halaman profil
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});