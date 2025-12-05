<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Http\Requests\Student\IndexShowDeleteStudentRequest;
use App\Http\Requests\Student\StoreUpdateStudentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexShowDeleteStudentRequest $request)
    {
        try {
            $students = Student::all();
            return response()->json($students);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al obtener estudiantes.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateStudentRequest $request)
    {
        try {
            $student = new Student;
            $student = $student->fill($request->validated());
            $student->save();

            return response()->json([
                'message' => 'Estudiante creado.'
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al crear estudiante.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(IndexShowDeleteStudentRequest $request, int $id)
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json($student);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Estudiante no encontrado.'
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al obtener estudiante.'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateStudentRequest $request, int $id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->fill($request->validated());
            $student->save();

            return response()->json([
                'message' => 'Estudiante actualizado.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Estudiante no encontrado.'
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al actualizar estudiante.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndexShowDeleteStudentRequest $request, int $id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json([
                'message' => 'Estudiante eliminado.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Estudiante no encontrado.'
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al eliminar estudiante.'
            ], 500);
        }
    }
}
