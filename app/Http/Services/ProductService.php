<?php

namespace App\Http\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    public function index($query): JsonResource
    {
        $page = $query->get('page', 1);

        $products = Cache::tags(['Product'])
            ->remember(
                "products_page_$page",
                60,
                fn () => Product::paginate(15)
            );

        return ProductResource::collection($products);
    }
}
