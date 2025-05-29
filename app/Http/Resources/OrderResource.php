<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *        schema="Order",
 *          @OA\Property(
 *              property="id",
 *              type="integer",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="product",
 *              ref="#/components/schemas/Product"
 *          ),
 *          @OA\Property(
 *              property="type",
 *              type="string",
 *              example="rent"
 *          ),
 *          @OA\Property(
 *              property="start_at",
 *              type="string",
 *              example="2025-05-29 13:09:37"
 *          ),
 *          @OA\Property(
 *              property="end_at",
 *              type="string",
 *              example="2025-05-29 13:09:37"
 *          ),
 *          @OA\Property(
 *              property="is_active",
 *              type="boolean",
 *              example="1"
 *          ),
 *          @OA\Property(
 *              property="code",
 *              type="string",
 *              example="EJASUABIMT"
 *          ),
 *          @OA\Property(
 *              property="created_at",
 *              type="string",
 *              example="2025-05-29T13:09:37.000000Z"
 *          )
 *   )
 */
class OrderResource extends JsonResource
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
            'product' => new ProductResource($this->product),
            'type' => $this->type,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'is_active' => $this->is_active,
            'code' => $this->code,
            'created_at' => $this->created_at,
        ];
    }
}
