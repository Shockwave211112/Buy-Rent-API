<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\FillRequest;
use App\Http\Services\WalletService;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new WalletService();
    }

    /**
     * Пополнение кошелька, заглушка
     *
     * @OA\Post(
     *       path="/api/wallet/fill",
     *       tags={"Wallet"},
     *       security={{"sanctum":{}}},
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(ref="#/components/schemas/WalletFillRequest")
     *               )
     *        ),
     *       @OA\Response(
     *             response=200, description="Успешно.",
     *             @OA\JsonContent(ref="#/components/schemas/MessageResponse")
     *         ),
     *       @OA\Response(response=401, description="Неавторизован."),
     *   )
     *
     * @param FillRequest $request
     * @return JsonResponse
     */
    public function fill(FillRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->fill($data);
    }
}
