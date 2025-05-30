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

        $sortBy = $query->get('sortBy', 'id');
        $sortBy = in_array($sortBy, ['id', 'price', 'rent_price_4h', 'rent_price_8h', 'rent_price_12h', 'rent_price_24h'])
            ? $sortBy
            : 'id';

        $sortDir = $query->get('dir', 'asc');
        $sortDir = in_array($sortDir, ['asc', 'desc']) ? $sortDir : 'asc';

        $search = $query->get('search', null);
        if ($search) {
            $products = Product::orderBy($sortBy, $sortDir)
                ->where('name', 'like', '%' . $search . '%')
                ->paginate(15);
        } else {
            $products = Cache::tags(['Product'])
                ->remember(
                    "products_page_{$page}_{$sortBy}_{$sortDir}",
                    60,
                    fn () => Product::orderBy($sortBy, $sortDir)
                        ->paginate(15)
                );
        }

        return ProductResource::collection($products);
    }
}
