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
    private function getReportData()
    {
        return [
            'totalMembers' => User::where('role', UserRole::MEMBER)->count(),
            'totalBooks' => Book::count(),
            'activeBorrowings' => Borrowing::where('status', 'dipinjam')->count(),
            'totalFines' => Fine::where('status', 'belum_dibayar')->sum('amount'),
            'popularBooks' => Book::withCount('borrowings')->orderBy('borrowings_count', 'desc')->take(5)->get(),
            'activeMembers' => User::where('role', UserRole::MEMBER)->withCount('borrowings')->orderBy('borrowings_count', 'desc')->take(5)->get(),
            'generationDate' => Carbon::now()->isoFormat('D MMMM YYYY, HH:mm:ss'),
        ];
    }

    public function index()
    {
        $data = $this->getReportData();
        return view('admin.reports.index', $data);
    }

    public function exportPdf()
    {
        $data = $this->getReportData();
        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        return $pdf->download('laporan-perpustakaan-' . date('Y-m-d') . '.pdf');
    }
}