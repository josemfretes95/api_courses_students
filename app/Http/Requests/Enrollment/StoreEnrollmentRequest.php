<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::user()->admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'integer',
                'exists:App\Models\Student,id',
                Rule::unique('enrollments', 'student_id')->where(function ($query) {
                    $query->where('course_id', $this->course_id);
                })
            ],
            'course_id' => 'required|integer|exists:App\Models\Course,id',
            'enrolled_at' => 'required|date',
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
            'student_id.required' => 'Campo obligatorio.',
            'student_id.integer' => 'Campo no válido.',
            'student_id.exists' => 'Estudiante no encontrado.',
            'student_id.unique' => 'Estudiante ya inscripto en el curso.',

            'course_id.required' => 'Campo obligatorio.',
            'course_id.integer' => 'Campo no válido.',
            'course_id.exists' => 'Curso no encontrado.',

            'enrolled_at.required' => 'Campo obligatorio.',
            'enrolled_at.date' => 'Fecha no válida.',
        ];
    }
}
