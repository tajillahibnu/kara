<?php

namespace Modules\Pkl\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class DudiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'required|email|unique:dudis,email',
        ];

        if ($this->route('id')) {
            $userId = $this->route('id'); // Ambil ID dari request body

            // Jika request untuk update, maka ubah validasi pada email dan username
            $rules['email'] = 'required|email|unique:dudis,email,' . $userId;
        }

        return $rules;
    }

    /**
     * Mendapatkan pesan kesalahan kustom untuk validasi ini.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email lain.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
