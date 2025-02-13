<?php

namespace Modules\Pkl\Http\Requests\Management;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            // 'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // 'username' => 'required|string|unique:users,username',
            // 'password' => 'required|string|min:8',
        ];

        // Periksa apakah parameter 'id' ada di dalam request untuk menentukan apakah ini update
        // echo 'asad';
        // echo $this->has('id');
        // echo '<br>';
        // echo $this->input('id');
        // echo $this->route('id');
        // exit;
        if ($this->route('id')) {
            $userId = $this->route('id'); // Ambil ID dari request body

            // Jika request untuk update, maka ubah validasi pada email dan username
            $rules['email'] = 'required|email|unique:users,email,' . $userId;
            // $rules['username'] = 'required|string|unique:users,username,' . $userId;
            // $rules['password'] = 'nullable|string|min:8'; // Password tidak wajib untuk update
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
            // 'username.unique' => 'Username sudah digunakan. Silakan gunakan username lain.',
            // 'password.min' => 'Password minimal 8 karakter.',
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
