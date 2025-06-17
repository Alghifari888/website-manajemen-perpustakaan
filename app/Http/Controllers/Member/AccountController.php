<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;
use App\Models\Fine;

class AccountController extends Controller
{
    /**
     * Menampilkan halaman profil utama anggota.
     */
    public function profile()
    {
        $user = Auth::user()->load('profile');

        $stats = [
            'active_borrowings' => Borrowing::where('user_id', $user->id)->where('status', 'dipinjam')->count(),
            'total_fines' => Fine::where('user_id', $user->id)->where('status', 'belum_dibayar')->sum('amount'),
        ];

        return view('member.account.profile', compact('user', 'stats'));
    }

    /**
     * Menampilkan riwayat peminjaman anggota.
     */
    public function history()
    {
        $borrowings = Borrowing::where('user_id', Auth::id())
                                ->with('book')
                                ->latest()
                                ->paginate(10);

        return view('member.account.history', compact('borrowings'));
    }

    /**
     * Menampilkan denda yang dimiliki anggota.
     */
    public function fines()
    {
        $fines = Fine::where('user_id', Auth::id())
                     ->with('borrowing.book')
                     ->latest()
                     ->paginate(10);
        
        return view('member.account.fines', compact('fines'));
    }
}