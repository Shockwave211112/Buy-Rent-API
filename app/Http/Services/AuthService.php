<?php

namespace App\Http\Services;

use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $data): JsonResponse
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AuthException('Неправильные данные', 403);
        }

        return new JsonResponse([
            'token' => $user->createToken('auth')->plainTextToken,
        ]);
    }

    public function register(array $data): JsonResponse
    {
        $user = User::create($data);

        return new JsonResponse([
            'token' => $user->createToken('auth')->plainTextToken,
        ]);
    }
}
