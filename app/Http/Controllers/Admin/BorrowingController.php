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
use App\Models\Fine; // Tambahkan ini


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
            // 1. Ambil data buku yang akan dipinjam
            $book = Book::find($data['book_id']);

            // 2. Kurangi stok buku yang tersedia
            $book->decrement('available_quantity');

            // 3. Simpan data peminjaman
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

    public function returnBook(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // 1. Update status peminjaman
            $borrowing->update([
                'status' => 'dikembalikan',
                'returned_at' => Carbon::now(),
            ]);

            // 2. Tambah kembali stok buku yang tersedia
            $borrowing->book()->increment('available_quantity');

            // 3. Cek keterlambatan dan buat denda jika perlu
            if (Carbon::now()->greaterThan($borrowing->due_at)) {
                $daysOverdue = Carbon::now()->diffInDays($borrowing->due_at);
                $fineAmount = $daysOverdue * 1000; // Denda Rp 1.000 per hari

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
            // Jika transaksi yang dihapus statusnya masih dipinjam,
            // kembalikan dulu stok bukunya agar tidak hilang.
            if ($borrowing->status !== 'dikembalikan') {
                $borrowing->book()->increment('available_quantity');
            }

            // Hapus data peminjaman. Denda terkait akan terhapus otomatis karena cascade.
            $borrowing->delete();

            DB::commit();

            return redirect()->route('admin.borrowings.index')->with('success', 'Data transaksi berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi. Error: ' . $e->getMessage());
        }
    }
}