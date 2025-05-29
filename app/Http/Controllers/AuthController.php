<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\AuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    /**
     *
     * @OA\Post(
     *      path="/api/auth/login",
     *      summary="Авторизация.",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/LoginRequest")
     *              )
     *       ),
     *      @OA\Response(
     *           response=200, description="Successfull login.",
     *           @OA\JsonContent(ref="#/components/schemas/UserToken")
     *       ),
     *      @OA\Response(response=403, description="Wrong data."),
     *      @OA\Response(response=422, description="Validation error.")
     *  )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        return $this->service->login($data);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/register",
     *      summary="Регистрация пользователя.",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/RegisterRequest")
     *              )
     *       ),
     *      @OA\Response(
     *           response=200, description="Successfull registration.",
     *           @OA\JsonContent(ref="#/components/schemas/UserToken")
     *       ),
     *      @OA\Response(response=422, description="Validation error.")
     *  )
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        return $this->service->register($data);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/logout",
     *      summary="Выход из системы.",
     *      tags={"Auth"},
     *      security={{"sanctum":{}}},
     *      @OA\Response(
     *           response=200, description="Successfull logout.",
     *           @OA\JsonContent(ref="#/components/schemas/MessageResponse")
     *       ),
     *      @OA\Response(response=401, description="Unauthenticated.")
     *  )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return new JsonResponse(['message' => 'Logout success']);
    }

    /**
     * @OA\Get(
     *        path="/api/me",
     *        summary="Возвращает информацию об авторизованном пользователе.",
     *        tags={"Auth"},
     *        security={{"sanctum":{}}},
     *        @OA\Response(
     *             response=200, description="Successfull logout.",
     *             @OA\JsonContent(ref="#/components/schemas/User")
     *         ),
     *        @OA\Response(response=401, description="Unauthenticated.")
     *    )
     *
     * @param Request $request
     * @return User
     */
    public function me(Request $request): User
    {
        return $request->user();
    }
}
