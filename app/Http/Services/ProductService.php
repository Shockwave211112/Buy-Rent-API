<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductService
{
    public function index(): JsonResource
    {
        $products = Product::paginate('15');

        return ProductResource::collection($products);
    }
}
