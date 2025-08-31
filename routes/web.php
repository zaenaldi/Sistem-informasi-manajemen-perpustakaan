<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;


// Welcome Page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/search', [WelcomeController::class, 'search'])->name('search');
Route::get('/buku/{id}', [WelcomeController::class, 'detail'])->name('buku.detail');

// Authentication
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin' 
        ? redirect()->route('admin.dashboard')
        : redirect()->route('petugas.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Profile Routes
    Route::get('/profile', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::delete('/profile', [AdminController::class, 'destroyProfile'])->name('admin.profile.destroy');

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Other Admin Routes
    Route::resource('petugas', PetugasController::class)->except(['show'])
        ->names([
            'index' => 'admin.petugas.index',
            'create' => 'admin.petugas.create',
            'store' => 'admin.petugas.store',
            'edit' => 'admin.petugas.edit',
            'update' => 'admin.petugas.update',
            'destroy' => 'admin.petugas.destroy'
        ]);
    
    Route::get('/aktivitas', [AdminController::class, 'aktivitas'])->name('admin.aktivitas');
});

// Petugas Routes
Route::prefix('petugas')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/profile', [PetugasController::class, 'editProfile'])->name('petugas.profile.edit');
    Route::put('/profile', [PetugasController::class, 'updateProfile'])->name('petugas.profile.update');
    Route::put('/profile/password', [PetugasController::class, 'updatePassword'])->name('petugas.profile.password');
    Route::delete('/profile', [PetugasController::class, 'destroyProfile'])->name('petugas.profile.destroy');

    Route::resource('buku', BukuController::class)->names('petugas.buku');
    Route::resource('pengunjung', PengunjungController::class)->names([
        'index' => 'petugas.pengunjung.index',
        'create' => 'petugas.pengunjung.create',
        'store' => 'petugas.pengunjung.store',
        'show' => 'petugas.pengunjung.show',
        'edit' => 'petugas.pengunjung.edit',
        'update' => 'petugas.pengunjung.update',
        'destroy' => 'petugas.pengunjung.destroy'
    ]);
    Route::resource('peminjaman', PeminjamanController::class)->names('petugas.peminjaman');;
    Route::post('/peminjaman/{peminjaman}/pengembalian', [PeminjamanController::class, 'pengembalian'])->name('peminjaman.pengembalian');
    Route::resource('pengembalian', PengembalianController::class)->names('petugas.pengembalian');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('petugas.laporan');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('petugas.laporan.cetak');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('petugas.laporan.export');
});

// Buku Search
Route::get('/cari-buku', [BukuController::class, 'cari'])->name('cari.buku');

require __DIR__.'/auth.php';