<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Enums\UserRole;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Statistik Ringkas
        $totalMembers = User::where('role', UserRole::MEMBER)->count();
        $totalBooks = Book::count();
        $activeBorrowings = Borrowing::where('status', 'dipinjam')->count();
        $totalFines = Fine::where('status', 'belum_dibayar')->sum('amount');

        // Buku Terpopuler (Top 5)
        $popularBooks = Book::withCount('borrowings')
                            ->orderBy('borrowings_count', 'desc')
                            ->take(5)
                            ->get();
        
        // Anggota Paling Aktif (Top 5)
        $activeMembers = User::where('role', UserRole::MEMBER)
                            ->withCount('borrowings')
                            ->orderBy('borrowings_count', 'desc')
                            ->take(5)
                            ->get();

        return view('admin.reports.index', compact(
            'totalMembers', 'totalBooks', 'activeBorrowings', 'totalFines',
            'popularBooks', 'activeMembers'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Mengambil data yang sama dengan method index
        $totalMembers = User::where('role', UserRole::MEMBER)->count();
        $totalBooks = Book::count();
        $activeBorrowings = Borrowing::where('status', 'dipinjam')->count();
        $totalFines = Fine::where('status', 'belum_dibayar')->sum('amount');
        $popularBooks = Book::withCount('borrowings')->orderBy('borrowings_count', 'desc')->take(10)->get();
        $activeMembers = User::where('role', UserRole::MEMBER)->withCount('borrowings')->orderBy('borrowings_count', 'desc')->take(10)->get();

        $data = [
            'totalMembers' => $totalMembers,
            'totalBooks' => $totalBooks,
            'activeBorrowings' => $activeBorrowings,
            'totalFines' => $totalFines,
            'popularBooks' => $popularBooks,
            'activeMembers' => $activeMembers,
            'generationDate' => Carbon::now()->format('d-m-Y H:i:s'),
        ];

        // Buat PDF
        $pdf = Pdf::loadView('admin.reports.pdf', $data);

        // Download PDF
        return $pdf->download('laporan-perpustakaan-' . date('Y-m-d') . '.pdf');
    }
}