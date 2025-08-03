<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content_type_id' => 'required|exists:content_types,id',
            'title' => 'required|string|max:255',
            'input_data' => 'required|array',
            'input_data.*' => 'required|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'content_type_id.required' => 'Jenis konten harus dipilih.',
            'content_type_id.exists' => 'Jenis konten tidak valid.',
            'title.required' => 'Judul konten harus diisi.',
            'title.max' => 'Judul konten maksimal 255 karakter.',
            'input_data.required' => 'Data input harus diisi.',
            'input_data.*.required' => 'Semua field input harus diisi.',
        ];
    }
}