<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::user()->admin);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim(Str::upper($this->name)),
            'email' => trim(Str::lower($this->email)),
            'password' => strval($this->password),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|string|min:8',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Campo obligatorio.',

            'email.required' => 'Campo obligatorio.',
            'email.email' => 'Correo no válido.',
            'email.unique' => 'Correo ya registrado.',

            'password.required' => 'Campo obligatorio.',
            'password.min' => 'La longitud mínima es de 8 caracteres.',
        ];
    }
}
