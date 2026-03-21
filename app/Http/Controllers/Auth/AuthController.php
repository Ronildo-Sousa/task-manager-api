<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AuthUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $payload = $request->validated();

        try {
            $result = app(AuthUser::class)->login($payload);
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function logout()
    {
        try {
            app(AuthUser::class)->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
