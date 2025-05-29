<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *        schema="Product",
 *          @OA\Property(
 *              property="id",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="name",
 *              type="string",
 *              example="Steam Account"
 *          ),
 *          @OA\Property(
 *              property="price",
 *              type="decimal",
 *              example="15000.00"
 *          ),
 *          @OA\Property(
 *              property="rent_price_4h",
 *              type="decimal",
 *              example="100.00"
 *          ),
 *          @OA\Property(
 *              property="rent_price_8h",
 *              type="decimal",
 *              example="200.00"
 *          ),
 *          @OA\Property(
 *              property="rent_price_12h",
 *              type="decimal",
 *              example="400.00"
 *          ),
 *          @OA\Property(
 *              property="rent_price_24h",
 *              type="decimal",
 *              example="800.00"
 *          ),
 *          @OA\Property(
 *              property="deleted_at",
 *              type="boolean",
 *              example="false"
 *          ),
 *   )
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'count' => $this->count,
            'price' => $this->price,
            'rent_price_4h' => $this->rent_price_4h,
            'rent_price_8h' => $this->rent_price_8h,
            'rent_price_12h' => $this->rent_price_12h,
            'rent_price_24h' => $this->rent_price_24h,
            'deleted_at' => (bool) $this->deleted_at,
        ];
    }
}
