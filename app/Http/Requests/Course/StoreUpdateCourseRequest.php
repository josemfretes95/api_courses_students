<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreUpdateCourseRequest extends FormRequest
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
            'title' => trim(Str::upper($this->title)),
            'description' => trim(Str::upper($this->description)),
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
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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
            'title.required' => 'Campo obligatorio.',

            'description.required' => 'Campo obligatorio.',

            'start_date.required' => 'Campo obligatorio.',
            'start_date.date' => 'Fecha no válida.',

            'end_date.required' => 'Campo obligatorio.',
            'end_date.date' => 'Fecha no válida.',
            'end_date.after_or_equal' => 'Fecha Fin no puede ser menor que Fecha Inicio.',
        ];
    }
}
