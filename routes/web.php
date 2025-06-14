<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
// Namespace controller akan kita buat nanti
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Halaman utama untuk tamu (tidak perlu login)
Route::get('/', function () {
    return view('welcome');
});

// Grup rute untuk semua pengguna yang sudah terautentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================================
// GRUP RUTE UNTUK ADMIN
// ===================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
   Route::resource('books', AdminBookController::class);
Route::resource('categories', AdminCategoryController::class);
Route::resource('members', \App\Http\Controllers\Admin\MemberController::class);
    // Tambahkan rute admin lainnya (manajemen anggota, laporan) di sini
});

// ===================================
// GRUP RUTE UNTUK PETUGAS
// ===================================
Route::middleware(['auth', 'role:petugas,admin'])->prefix('officer')->name('officer.')->group(function () {
    // Rute untuk validasi peminjaman, pengembalian, denda.
    // Admin juga diberi akses ke rute petugas.
});

// ===================================
// GRUP RUTE UNTUK ANGGOTA
// ===================================
Route::middleware(['auth', 'role:anggota'])->prefix('member')->name('member.')->group(function () {
    // Rute untuk melihat histori peminjaman, katalog buku.
});


// Memanggil file rute autentikasi dari Breeze
require __DIR__.'/auth.php';