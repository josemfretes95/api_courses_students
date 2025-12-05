<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\User\StoreUserRequest;
use Exception;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        try {
            $user = new User;
            $user = $user->fill($request->validated());
            $user->admin = true;
            $user->save();

            return response()->json([
                'message' => 'Usuario creado.'
            ]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json([
                'message' => 'Error al crear usuario.'
            ], 500);
        }
    }
}
