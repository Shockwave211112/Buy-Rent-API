<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *        schema="User",
 *        @OA\Property(
 *            property="data",
 *            type="object",
 *        @OA\Property(
 *            property="id",
 *            type="integer",
 *            example="1"
 *        ),
 *        @OA\Property(
 *            property="name",
 *            type="string",
 *            example="Example"
 *        ),
 *        @OA\Property(
 *            property="email",
 *            type="string",
 *            example="example@mail.com"
 *        ),
 *        @OA\Property(
 *            property="wallet_balance",
 *            type="decimal",
 *            example="199.99"
 *        ),
 *     )
 *   )
 */
class UserResource extends JsonResource
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
            'email' => $this->email,
            'wallet_balance' => $this->wallet->balance,
        ];
    }
}
