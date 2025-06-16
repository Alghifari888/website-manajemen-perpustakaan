<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Fine;
use App\Http\Requests\Admin\BorrowingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book', 'processor']);

        // Logika untuk Pencarian (di tabel relasi)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('book', function ($bookQuery) use ($search) {
                    $bookQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Logika untuk Filter Status
        if ($request->filled('status')) {
            if ($request->input('status') == 'terlambat') {
                $query->where('status', 'dipinjam')->where('due_at', '<', now());
            } else {
                $query->where('status', $request->input('status'));
            }
        }

        $borrowings = $query->latest()->paginate(15);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = User::where('role', UserRole::MEMBER)->get();
        $books = Book::where('available_quantity', '>', 0)->get();
        $default_due_date = Carbon::now()->addDays(7)->format('Y-m-d');

        return view('admin.borrowings.create', compact('members', 'books', 'default_due_date'));
    }

    public function store(BorrowingRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $book = Book::find($data['book_id']);
            $book->decrement('available_quantity');

            Borrowing::create([
                'user_id' => $data['user_id'],
                'book_id' => $data['book_id'],
                'borrowed_at' => Carbon::now(),
                'due_at' => Carbon::parse($data['due_at']),
                'status' => 'dipinjam',
                'processed_by_user_id' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman buku berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat peminjaman. Error: ' . $e->getMessage())->withInput();
        }
    }

    public function returnBook(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $borrowing->update([
                'status' => 'dikembalikan',
                'returned_at' => Carbon::now(),
            ]);
            $borrowing->book()->increment('available_quantity');

            if (Carbon::now()->greaterThan($borrowing->due_at)) {
                $daysOverdue = Carbon::now()->diffInDays($borrowing->due_at);
                $fineAmount = $daysOverdue * 1000;

                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'user_id' => $borrowing->user_id,
                    'amount' => $fineAmount,
                    'reason' => "Terlambat {$daysOverdue} hari.",
                    'status' => 'belum_dibayar',
                ]);
            }
            DB::commit();
            return redirect()->route('admin.borrowings.index')->with('success', 'Buku telah berhasil dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengembalian. Error: ' . $e->getMessage());
        }
    }

    public function destroy(Borrowing $borrowing)
    {
        DB::beginTransaction();
        try {
            if ($borrowing->status !== 'dikembalikan') {
                $borrowing->book()->increment('available_quantity');
            }
            $borrowing->delete();
            DB::commit();
            return redirect()->route('admin.borrowings.index')->with('success', 'Data transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi. Error: ' . $e->getMessage());
        }
    }
}