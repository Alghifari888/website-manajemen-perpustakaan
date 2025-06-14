<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use App\Enums\UserRole;
use App\Http\Requests\Admin\BorrowingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index()
    {
        // Eager load relasi untuk menghindari N+1 query problem
        $borrowings = Borrowing::with(['user', 'book', 'processor'])
                                ->latest()
                                ->paginate(15);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        // Ambil hanya user dengan role 'anggota'
        $members = User::where('role', UserRole::MEMBER)->get();
        // Ambil hanya buku dengan stok tersedia
        $books = Book::where('available_quantity', '>', 0)->get();
        // Default tanggal jatuh tempo (misal: 7 hari dari sekarang)
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
                'processed_by_user_id' => Auth::id(), // ID petugas/admin yang login
            ]);

            DB::commit();

            return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman buku berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat peminjaman. Error: ' . $e->getMessage())->withInput();
        }
    }

    // metode returnBook dan destroy akan ditambahkan nanti
}