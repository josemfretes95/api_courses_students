<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Requests\Course\IndexShowDeleteCourseRequest;
use App\Http\Requests\Course\StoreUpdateCourseRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexShowDeleteCourseRequest $request)
    {
        try {
            $courses = Course::all();
            return response()->json($courses);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al obtener cursos.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCourseRequest $request)
    {
        try {
            $course = new Course;
            $course = $course->fill($request->validated());
            $course->save();

            return response()->json([
                'message' => 'Curso creado.'
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al crear curso.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(IndexShowDeleteCourseRequest $request, int $id)
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json($course);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Curso no encontrado.'
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al obtener curso.'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateCourseRequest $request, int $id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->fill($request->validated());
            $course->save();

            return response()->json([
                'message' => 'Curso actualizado.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Curso no encontrado.'
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al actualizar curso.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndexShowDeleteCourseRequest $request, int $id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'message' => 'Curso eliminado.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Curso no encontrado.'
            ], 404);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al eliminar curso.'
            ], 500);
        }
    }
}
