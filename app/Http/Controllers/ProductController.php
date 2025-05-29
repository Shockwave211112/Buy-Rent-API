<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
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
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        return $this->service->index();
    }
}
