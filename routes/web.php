<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    // Gateway Dashboard Terpusat
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Grup Admin[cite: 1]
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    });

    // Grup Guru[cite: 1]
    Route::middleware('role:guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guruDashboard'])->name('dashboard');
    });

    // Grup Siswa[cite: 1]
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswaDashboard'])->name('dashboard');
    });
});

require __DIR__.'/auth.php';
