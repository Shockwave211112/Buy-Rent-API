<?php

namespace App\Http\Controllers;

use App\Exceptions\OrderException;
use App\Http\Requests\Order\CreateRequest;
use App\Http\Requests\Order\ExtendRequest;
use App\Http\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    /**
     * Список заказов, оформленных пользователем
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return $this->service->index();
    }

    /**
     * Покупка товара
     *
     * @OA\Post(
     *      path="/api/orders",
     *      summary="Оформление заказа",
     *      description="type = rent | purchase. Если type = 'rent', то необходимо также поле time.",
     *      tags={"Orders"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateOrderRequest")
     *              )
     *       ),
     *      @OA\Response(
     *            response=200, description="Успешно.",
     *            @OA\JsonContent(ref="#/components/schemas/MessageResponse")
     *        ),
     *      @OA\Response(response=401, description="Неавторизован."),
     *      @OA\Response(response=404, description="Товар не найден."),
     *      @OA\Response(response=422, description="На балансе недостаточно средств/Товар закончился."),
     *      @OA\Response(response=500, description="Во время создания заказа произошла ошибка."),
     *  )
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws OrderException
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->create($data);
    }

    /**
     * Продление аренды
     *
     * @OA\Post(
     *       path="/api/orders/{id}/extend",
     *       summary="Продление аренды",
     *       tags={"Orders"},
     *       security={{"sanctum":{}}},
     *      @OA\Parameter(
     *           description="ID заказа.",
     *           in="path",
     *           name="id",
     *           required=true,
     *           example="1"
     *       ),
     *       @OA\RequestBody(
     *           required=true,
     *           @OA\MediaType(
     *               mediaType="application/json",
     *               @OA\Schema(ref="#/components/schemas/ExtendOrderRequest")
     *               )
     *        ),
     *       @OA\Response(
     *             response=200, description="Успешно.",
     *             @OA\JsonContent(ref="#/components/schemas/MessageResponse")
     *         ),
     *       @OA\Response(response=401, description="Неавторизован."),
     *       @OA\Response(response=404, description="Заказ не найден."),
     *       @OA\Response(response=422, description="Истёк срок аренды/Товар удалён/Итоговая аренда больше 24 часов/Недостаточно средств"),
     *   )
     * @param ExtendRequest $request
     * @return JsonResponse
     * @throws OrderException
     */
    public function extend(ExtendRequest $request): JsonResponse
    {
        $data = $request->validated();

        return $this->service->extend($request->id, $data);
    }

    /**
     * Показать информацию о заказе
     *
     * @OA\Get(
     *        path="/api/orders/{id}",
     *        summary="Просмотреть заказ",
     *        tags={"Orders"},
     *        security={{"sanctum":{}}},
     *       @OA\Parameter(
     *            description="ID заказа.",
     *            in="path",
     *            name="id",
     *            required=true,
     *            example="1"
     *        ),
     *        @OA\Response(
     *              response=200, description="Успешно.",
     *              @OA\JsonContent(
     *               @OA\Property(property="data", ref="#/components/schemas/Order"),
     *              )
     *          ),
     *        @OA\Response(response=401, description="Неавторизован."),
     *        @OA\Response(response=403, description="Недостаточно прав."),
     *        @OA\Response(response=404, description="Заказ не найден.")
     *    )
     * )
     * @param Request $request
     * @return JsonResource
     * @throws OrderException
     */
    public function show(Request $request): JsonResource
    {
        return $this->service->show($request->id);
    }
}
