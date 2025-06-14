<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class BorrowingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => [
                'required',
                'exists:books,id',
                // Custom validation rule
                function ($attribute, $value, $fail) {
                    $book = Book::find($value);
                    if ($book && $book->available_quantity <= 0) {
                        $fail('Buku yang dipilih tidak tersedia atau stok habis.');
                    }
                },
            ],
            'due_at' => 'required|date|after_or_equal:today',
        ];
    }
}