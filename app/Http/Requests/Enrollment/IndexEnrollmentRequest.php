<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IndexEnrollmentRequest extends FormRequest
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
            'page' => $this->query('page') ?? 1,
            'limit' => $this->query('limit') ?? 10,
            'sort' => trim(Str::lower($this->query('sort') ?? 'asc')),
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
            'student_id' => 'nullable|integer',
            'course_id' => 'nullable|integer',
            'page' => 'required|integer',
            'limit' => 'required|integer',
            'sort' => 'required|string|in:asc,desc',
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
            'student_id.integer' => 'Campo no válido.',

            'course_id.integer' => 'Campo no válido.',

            'page.required' => 'Campo obligatorio.',
            'page.integer' => 'Campo no válido.',

            'limit.required' => 'Campo obligatorio.',
            'limit.integer' => 'Campo no válido.',

            'sort.required' => 'Campo obligatorio.',
            'sort.in' => 'Debe indicar asc o desc.',
        ];
    }
}
