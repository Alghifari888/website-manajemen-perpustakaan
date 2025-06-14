<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\Admin\BookStoreRequest;
use App\Http\Requests\Admin\BookUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
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