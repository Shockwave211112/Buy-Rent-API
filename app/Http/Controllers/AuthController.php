<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        return $this->service->login($data);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        return $this->service->register($data);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return new JsonResponse(['message' => 'Logout success']);
    }
}
