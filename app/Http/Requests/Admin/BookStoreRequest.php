<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani oleh middleware 'role:admin'
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => 'required|string|unique:books,isbn', // ISBN harus unik di tabel books
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB
        ];
    }
}