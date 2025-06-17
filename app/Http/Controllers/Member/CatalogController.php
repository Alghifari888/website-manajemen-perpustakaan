<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Logika ini sama persis dengan BookController milik Admin
        $query = Book::query()->with('category');

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Logika Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $books = $query->latest()->paginate(12); // Tampilkan 12 buku per halaman untuk layout kartu
        $categories = Category::all();

        return view('member.catalog.index', compact('books', 'categories'));
    }
}