<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $params = $request->validated();
        $user = User::where('email', $params['email'])->first();

        // Verificar credenciales
        if (empty($user) || !Hash::check($params['password'], $user->password)) {
            return response()->json([
                'message' => 'Email y/o Contraseña no válidos.',
            ], 401);
        }

        // Crear token personal
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => [
                'nombre' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Se cerró la sesión.',
        ]);
    }
}
