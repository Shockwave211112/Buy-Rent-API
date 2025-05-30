<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    /**
     * Вывод всех товаров.
     *
     * @OA\Get(
     *      path="/api/products",
     *      summary="Вывод всех товаров.",
     *      tags={"Products"},
     *      @OA\Parameter(
     *            description="Страница",
     *            in="query",
     *            name="page",
     *            required=false,
     *            example="page=1"
     *        ),
     *      @OA\Parameter(
     *            description="Порядок сортировки",
     *            in="query",
     *            name="sortBy",
     *            required=false,
     *            example="sortBy=price"
     *        ),
     *       @OA\Parameter(
     *             description="Направление сортировки",
     *             in="query",
     *             name="dir",
     *             required=false,
     *             example="dir=desc"
     *         ),
     *       @OA\Parameter(
     *             description="Поиск по названию",
     *             in="query",
     *             name="search",
     *             required=false,
     *             example="search=Steam"
     *         ),
     *      @OA\Response(
     *           response=200, description="Пагинированный список.",
     *           @OA\JsonContent(ref="#/components/schemas/ProductsListPaginated")
     *       )
     *  )
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        return $this->service->index($request->query);
    }
}
