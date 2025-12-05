<?php

namespace App\Http\Controllers\Enrollment;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Http\Requests\Enrollment\IndexEnrollmentRequest;
use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\Enrollment\DeleteEnrollmentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;
use PDOException;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexEnrollmentRequest $request)
    {
        $params = $request->validated();

        try {
            $query = Enrollment::query();

            if (isset($params['student_id'])) {
                $query->where('student_id', $params['student_id']);
            }

            if (isset($params['course_id'])) {
                $query->where('course_id', $params['course_id']);
            }

            $query->orderBy('enrolled_at', $params['sort']);

            $enrollments = $query->paginate($params['limit']);

            return response()->json([
                'data' => $enrollments->items(),
                'meta' => [
                    'current_page' => $enrollments->currentPage(),
                    'per_page' => $enrollments->perPage(),
                    'total' => $enrollments->total(),
                    'last_page' => $enrollments->lastPage(),
                ]
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al obtener inscripciones.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        try {
            $enrollment = new Enrollment;
            $enrollment = $enrollment->fill($request->validated());
            $enrollment->save();

            return response()->json([
                'message' => 'Inscripción creada.'
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al crear inscripción.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteEnrollmentRequest $request, int $id)
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();

            return response()->json([
                'message' => 'Inscripción eliminada.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Inscripción no encontrada.'
            ], 404);
        } catch (Exception $e) {
            if ($e instanceof PDOException) {
                if ($e->getCode() == '23503') {
                    return response()->json([
                        'message' => 'No se puede eliminar porque tiene datos relacionados.'
                    ], 400);
                }
            } else {
                Log::error($e);

                return response()->json([
                    'message' => 'Error al eliminar inscripción.'
                ], 500);
            }
        }
    }
}
