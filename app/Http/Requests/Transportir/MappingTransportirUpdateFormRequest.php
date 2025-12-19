<?php

namespace App\Http\Requests\Transportir;

use Illuminate\Foundation\Http\FormRequest;

class MappingTransportirUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user && $user->role->value === 'SUPERADMIN';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transportir_id' => ['required', 'integer', 'exists:transportirs,id'],
            'driver_id'      => ['required', 'integer', 'exists:drivers,id'],
            'is_active'      => ['required', 'in:0,1'],
        ];
    }
}
