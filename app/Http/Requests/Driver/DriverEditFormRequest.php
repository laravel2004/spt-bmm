<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DriverEditFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user && $user->role->value === 'SUPERADMIN';
    }

    public function rules(): array
    {
        $id = (int) $this->route('id'); // ini ID DRIVER (bukan user)

        // NOTE: kita butuh user_id untuk ignore unique
        // kita kirim dari controller lewat hidden input (user_id)
        $userId = (int) $this->input('user_id');

        return [
            'user_id'         => ['required', 'integer', 'exists:users,id'],

            // ===== USERS =====
            'username'        => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'user_fullname'   => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone_num'       => ['nullable', 'string', 'max:30'],
            'password'        => ['nullable', 'string', 'min:8', 'confirmed'], // optional saat update

            // ===== DRIVERS =====
            'driver_fullname' => ['nullable', 'string', 'max:255'],
            'birthday'        => ['nullable', 'date'],
            'place_of_birth'  => ['nullable', 'string', 'max:255'],

            'address_type'    => ['nullable', Rule::in(['Pribadi','Ortu','Sewa','Lain','Kost','KPR'])],
            'address'         => ['nullable', 'string'],
            'rttw'            => ['nullable', 'string', 'max:50'],
            'village'         => ['nullable', 'string', 'max:255'],
            'sub_district'    => ['nullable', 'string', 'max:255'],
            'district'        => ['nullable', 'string', 'max:255'],
            'city'            => ['nullable', 'string', 'max:255'],
            'province'        => ['nullable', 'string', 'max:255'],
            'zipcode'         => ['nullable', 'string', 'max:20'],

            'marital_status'  => ['nullable', Rule::in(['Lajang','Menikah','Duda','Janda'])],
            'religion'        => ['nullable', 'string', 'max:50'],
            'gender'          => ['nullable', Rule::in(['Laki-laki','Perempuan'])],
            'last_education'  => ['nullable', 'string', 'max:100'],
            'no_ktp'          => ['nullable', 'string', 'max:50'],
            'driver_type'     => ['nullable', 'string', 'max:50'],

            'status'          => ['required', 'boolean'],
            'is_active'       => ['required', 'boolean'],
            'reference_code'  => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status'    => $this->boolean('status', true),
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
