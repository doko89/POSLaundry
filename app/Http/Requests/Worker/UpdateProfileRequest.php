<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,'.$this->user()->id,
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Nomor HP harus diisi',
            'phone.unique' => 'Nomor HP sudah digunakan',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.max' => 'Ukuran gambar maksimal 2MB'
        ];
    }
} 