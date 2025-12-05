<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Enrollment\EnrollmentController;

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [UserController::class, 'store']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::apiResource('courses', CourseController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('enrollments', EnrollmentController::class)->only([
        'index',
        'store',
        'destroy',
    ]);
});
