<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category; // Pastikan model Category sudah ada
use App\Http\Requests\Admin\BookStoreRequest;
use App\Http\Requests\Admin\BookUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dengan eager loading relasi kategori
        $query = Book::with('category');

        // 1. Logika untuk PENCARIAN
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // 2. Logika untuk FILTER KATEGORI
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Ambil hasil query dengan paginasi
        $books = $query->latest()->paginate(10);
        
        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }









    public function store(BookStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku baru berhasil ditambahkan.');
    }

    public function show(Book $book)
    {
        // Biasanya untuk API atau halaman detail. Kita bisa lewatkan untuk saat ini.
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($book->cover_image_path) {
                Storage::disk('public')->delete($book->cover_image_path);
            }
            // Simpan gambar baru
            $data['cover_image_path'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        // Hapus gambar dari storage sebelum menghapus data buku
        if ($book->cover_image_path) {
            Storage::disk('public')->delete($book->cover_image_path);
        }
        
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}