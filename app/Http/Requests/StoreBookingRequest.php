<?php
// app/Http/Requests/StoreBookingRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi role sudah ditangani middleware 'role:penghuni' di route
    }

    public function rules(): array
    {
        return [
            'durasi' => ['required', 'integer', 'min:1', 'max:36'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'durasi.required' => 'Durasi sewa wajib diisi.',
            'durasi.integer' => 'Durasi sewa harus berupa angka bulan.',
            'durasi.min' => 'Durasi sewa minimal 1 bulan.',
        ];
    }
}