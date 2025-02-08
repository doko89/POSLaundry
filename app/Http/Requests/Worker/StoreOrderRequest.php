<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0',
            'priority' => 'required|in:normal,high,express',
            'notes' => 'nullable|string',
            'total' => 'required|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'Pelanggan harus dipilih',
            'service_id.required' => 'Layanan harus dipilih',
            'weight.required' => 'Berat harus diisi',
            'weight.numeric' => 'Berat harus berupa angka',
            'weight.min' => 'Berat minimal 0',
            'priority.required' => 'Prioritas harus dipilih',
            'total.required' => 'Total harus diisi',
            'total.numeric' => 'Total harus berupa angka',
            'total.min' => 'Total minimal 0'
        ];
    }
} 