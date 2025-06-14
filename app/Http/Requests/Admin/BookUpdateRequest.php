<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book')->id;

        return [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => ['required', 'string', Rule::unique('books')->ignore($bookId)], // ISBN unik, kecuali untuk buku ini sendiri
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}