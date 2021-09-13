<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'group_id' => 'required|exists:groups,id',
            'rol_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'Campo requerido',
            'rut.unique' => 'Ya este rut esta registrado',
            'email.unique' => 'Ya este email esta en uso'
        ];
    }
}
