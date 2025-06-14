<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::with(['user', 'borrowing.book'])
                    ->latest()
                    ->paginate(15);

        return view('admin.fines.index', compact('fines'));
    }

    public function markAsPaid(Fine $fine)
    {
        if ($fine->status === 'lunas') {
            return back()->with('error', 'Denda ini sudah lunas sebelumnya.');
        }

        $fine->update([
            'status' => 'lunas',
            'paid_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.fines.index')->with('success', 'Denda telah berhasil ditandai lunas.');
    }
}