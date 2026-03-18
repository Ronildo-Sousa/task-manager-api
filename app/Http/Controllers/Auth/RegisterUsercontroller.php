<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\DTO\RegisterUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RegisterUsercontroller extends Controller
{
    public function __invoke(RegisterUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $payload = RegisterUserDto::fromArray($request->validated());

            app(RegisterUser::class)->execute($payload);

            DB::commit();

            return response()->json([
                'message' => 'User registered successfully',
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to register user',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
