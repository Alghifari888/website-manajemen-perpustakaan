<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($memberId)],
            'nis_nim' => ['nullable', 'string', 'max:255', Rule::unique('user_profiles', 'nis_nim')->ignore($memberId, 'user_id')],
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}