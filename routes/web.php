<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Import semua controller yang kita gunakan
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\FineController as AdminFineController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Member\CatalogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik (HALAMAN UTAMA)
// =========================================================================
// ## BAGIAN INI TELAH DIMODIFIKASI ##
// =========================================================================
Route::get('/', function () {
    // Jika sudah login, arahkan ke dashboard. Jika belum, arahkan ke halaman login.
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect('/login');
});

// Rute Dashboard Utama (setelah login)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk Halaman Profil Pengguna (bawaan Breeze)
Route::middleware('auth')->group(function () {
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
    Route::resource('members', AdminMemberController::class);
    
    Route::post('borrowings/{borrowing}/return', [AdminBorrowingController::class, 'returnBook'])->name('borrowings.return');
    Route::resource('borrowings', AdminBorrowingController::class)->except(['show', 'edit', 'update']);

    Route::get('fines', [AdminFineController::class, 'index'])->name('fines.index');
    Route::patch('fines/{fine}/pay', [AdminFineController::class, 'markAsPaid'])->name('fines.pay');
    
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export-pdf', [AdminReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

// ===================================
// GRUP RUTE UNTUK ANGGOTA (MEMBER)
// ===================================
Route::middleware(['auth', 'role:anggota'])->prefix('member')->name('member.')->group(function () {
    Route::get('catalog', [CatalogController::class, 'index'])->name('catalog.index');
    
    Route::get('account/profile', [\App\Http\Controllers\Member\AccountController::class, 'profile'])->name('account.profile');
    Route::get('account/history', [\App\Http\Controllers\Member\AccountController::class, 'history'])->name('account.history');
    Route::get('account/fines', [\App\Http\Controllers\Member\AccountController::class, 'fines'])->name('account.fines');
});


require __DIR__.'/auth.php';