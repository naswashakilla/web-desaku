<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('beranda');
});

// Route pengumuman publik
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/pengumuman/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

// Route admin (perlu login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin/pengumuman/buat', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/admin/pengumuman', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/admin/pengumuman/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/admin/pengumuman/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/admin/pengumuman/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

// Route keuangan
use App\Http\Controllers\DueController;
use App\Http\Controllers\DuePaymentController;
use App\Http\Controllers\TransactionController;

/// Publik — warga bisa lapor bayar tanpa login
Route::get('/keuangan', [DueController::class, 'index'])->name('finance.index');
Route::get('/keuangan/iuran/{due}', [DueController::class, 'show'])->name('finance.dues.show');
Route::get('/keuangan/transaksi', [TransactionController::class, 'index'])->name('finance.transactions.index');
Route::post('/keuangan/iuran/{due}/bayar', [DuePaymentController::class, 'store'])->name('finance.dues.pay');

// Admin only — perlu login
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/keuangan/iuran/buat', [DueController::class, 'create'])->name('finance.dues.create');
    Route::post('/admin/keuangan/iuran', [DueController::class, 'store'])->name('finance.dues.store');
    Route::delete('/admin/keuangan/iuran/{due}', [DueController::class, 'destroy'])->name('finance.dues.destroy');

    Route::get('/admin/keuangan/pembayaran/pending', [DuePaymentController::class, 'pending'])->name('finance.payments.pending');
    Route::post('/admin/keuangan/pembayaran/{payment}/confirm', [DuePaymentController::class, 'confirm'])->name('finance.payments.confirm');
    Route::post('/admin/keuangan/pembayaran/{payment}/reject', [DuePaymentController::class, 'reject'])->name('finance.payments.reject');

    Route::get('/admin/keuangan/transaksi/buat', [TransactionController::class, 'create'])->name('finance.transactions.create');
    Route::post('/admin/keuangan/transaksi', [TransactionController::class, 'store'])->name('finance.transactions.store');
    Route::delete('/admin/keuangan/transaksi/{transaction}', [TransactionController::class, 'destroy'])->name('finance.transactions.destroy');
});

use App\Http\Controllers\ReportController;

// Publik
Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
Route::get('/laporan/buat', [ReportController::class, 'create'])->name('reports.create');
Route::post('/laporan', [ReportController::class, 'store'])->name('reports.store');
Route::get('/laporan/{report}', [ReportController::class, 'show'])->name('reports.show');

// Admin only
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/laporan', [ReportController::class, 'adminIndex'])->name('reports.admin');
    Route::post('/admin/laporan/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');
});

// Route auth dari Breeze (login, register, logout, dll)
require __DIR__.'/auth.php';