<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $data): JsonResponse
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return new JsonResponse(['error' => 'Wrong password'], 401);
        }

        return new JsonResponse([
            'message' => 'Login success',
            'token' => $user->createToken('auth')->plainTextToken,
        ]);
    }

    public function register(array $data): JsonResponse
    {
        $user = User::create($data);

        return new JsonResponse([
            'message' => 'Registration successfully',
            'token' => $user->createToken('auth')->plainTextToken,
        ]);
    }
}
