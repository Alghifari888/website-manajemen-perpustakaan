<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Jika sedang edit, ambil ID kategori dari route
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            // Nama harus unik, kecuali untuk kategori itu sendiri saat sedang di-update
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($categoryId),
            ],
            'description' => 'nullable|string',
        ];
    }
}