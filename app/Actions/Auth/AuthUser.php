<?php

namespace App\Actions\Auth;

use Symfony\Component\HttpFoundation\Response;

class AuthUser
{
    private const TOKEN_TTL = 60;

    public function login(array $payload): array
    {
        $token = auth()->attempt($payload);
        if (!$token) {
            throw new \Exception('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * self::TOKEN_TTL,
        ];
    }

    public function logout(): void
    {
        auth()->logout();
    }
}