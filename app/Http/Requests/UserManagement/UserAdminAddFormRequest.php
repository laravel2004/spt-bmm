<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserAdminAddFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user && $user->role->value === 'ADMIN';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'        => ['required', 'string', 'max:255', 'unique:users,username'],
            'fullname'      => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'        => ['required', 'string', 'min:8'],
            'role'            => ['required', 'in:ADMIN'],
            'photo_text'      => ['nullable', 'image', 'max:2048'],
            'nipeg'           => ['nullable', 'string', 'max:50'],
            'phone_num'       => ['nullable', 'string', 'max:20'],
            'reference_code'  => ['nullable', 'string', 'max:100'],
            'is_active'       => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'role.in' => 'Role harus salah satu dari: ADMIN',
        ];
    }
}
