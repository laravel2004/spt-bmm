<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserAdminEditFormRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'fullname'      => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password'        => ['nullable', 'string', 'min:8'], // optional saat edit
            'role'            => ['required', 'in:ADMIN'],
            'photo_text'      => ['nullable', 'image', 'max:2048'],
            'nipeg'           => ['nullable', 'string', 'max:50'],
            'phone_num'       => ['nullable', 'string', 'max:20'],
            'reference_code'  => ['nullable', 'string', 'max:100'],
            'is_active'       => ['required', 'boolean'],
        ];
    }
}
