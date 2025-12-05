<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ForceJson;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ForceJson::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e) {
            return response()->json(['message' => 'No autenticado.'], 401);
        })->renderable(function (AccessDeniedHttpException $e) {
            return response()->json(['message' => 'Acceso no permitido.'], 403);
        })->renderable(function (ValidationException $e) {
            return response()->json([
                'message' => 'Corrija los siguientes errores.',
                'errors' => $e->errors()
            ], 422);
        });
    })->create();
