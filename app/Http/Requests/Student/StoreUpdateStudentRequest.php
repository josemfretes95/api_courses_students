<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreUpdateStudentRequest extends FormRequest
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
            'nationality' => trim(Str::upper($this->nationality)),
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
            'email' => 'required|string|unique:App\Models\Student,email',
            'birthday' => 'required|date',
            'nationality' => 'required|string',
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
            'email.unique' => 'Correo ya registrado.',

            'birthday.required' => 'Campo obligatorio.',
            'birthday.date' => 'Fecha no válida.',

            'nationality.required' => 'Campo obligatorio.',
        ];
    }
}
