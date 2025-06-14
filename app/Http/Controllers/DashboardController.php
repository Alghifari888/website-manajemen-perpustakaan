<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(UserRole::ADMIN->value)) {
            // Jika admin, arahkan ke dashboard admin (manajemen buku)
            return redirect()->route('admin.books.index');
        } elseif ($user->hasRole(UserRole::OFFICER->value)) {
            // Jika petugas, arahkan ke dashboard petugas (belum dibuat)
            // Untuk sementara, kita tampilkan view dashboard biasa
            return view('dashboard');
        } elseif ($user->hasRole(UserRole::MEMBER->value)) {
            // Jika anggota, arahkan ke dashboard anggota (belum dibuat)
            // Untuk sementara, kita tampilkan view dashboard biasa
            return view('dashboard');
        }

        // Default fallback
        return view('dashboard');
    }
}