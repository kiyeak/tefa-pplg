<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// Guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated (sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin only
    Route::middleware('admin')->group(function () {
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('peralatan', PeralatanController::class);
    });

    // All users
    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembali');
    Route::get('/peminjaman/json/data', [PeminjamanController::class, 'getData'])->name('peminjaman.json');

    // Export
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
});