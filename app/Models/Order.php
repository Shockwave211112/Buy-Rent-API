<?php

namespace App\Models;

use App\Enums\OrderTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *       schema="OrdersListPaginated",
 *       @OA\Property(
 *           property="data",
 *           type="array",
 *           @OA\Items(ref="#/components/schemas/Order")
 *       ),
 *       @OA\Property(
 *          property="links",
 *          type="object",
 *          @OA\Property(
 *              property="first",
 *              type="string",
 *              example="http://host/api/orders?page=1"
 *          ),
 *          @OA\Property(
 *              property="last",
 *              type="string",
 *              example="http://host/api/orders?page=2"
 *          ),
 *          @OA\Property(
 *              property="prev",
 *              type="string",
 *              example="null | http://host/api/orders?page=1"
 *          ),
 *          @OA\Property(
 *              property="next",
 *              type="string",
 *              example="null | http://host/api/orders?page=2"
 *          ),
 *       ),
 *       @OA\Property(
 *            property="meta",
 *            type="object",
 *                @OA\Property(
 *                      property="current_page",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                @OA\Property(
 *                      property="from",
 *                      type="integer",
 *                      example="1"
 *                  ),
 *                @OA\Property(
 *                      property="last_page",
 *                      type="integer",
 *                      example="3"
 *                  ),
 *                @OA\Property(
 *                      property="links",
 *                      type="array",
 *                      @OA\Items(
 *                          type="object",
 *                          @OA\Property(
 *                              property="url",
 *                              type="string",
 *                              example="null | http://host/api/orders?page=2"
 *                          ),
 *                          @OA\Property(
 *                              property="label",
 *                              type="string",
 *                              example="Next &raquo | 1 |&laquo; Previous"
 *                          ),
 *                          @OA\Property(
 *                              property="active",
 *                              type="boolean",
 *                              example="false | true"
 *                          ),
 *                      ),
 *                  ),
 *              @OA\Property(
 *                  property="path",
 *                  type="string",
 *                  example="http://host/api/orders"
 *              ),
 *              @OA\Property(
 *                  property="per_page",
 *                  type="integer",
 *                  example="15"
 *              ),
 *              @OA\Property(
 *                  property="to",
 *                  type="integer",
 *                  example="3"
 *              ),
 *              @OA\Property(
 *                  property="total",
 *                  type="integer",
 *                  example="3"
 *              ),
 *       ),
 *  )
 */
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'type',
        'is_active',
        'start_at',
        'end_at',
        'code',
        'code_generated_at'
    ];

    protected $casts = [
        'type' => OrderTypeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Является ли заказ арендой
     *
     * @return bool
     */
    public function isRent(): bool
    {
        return $this->type == OrderTypeEnum::Rent;
    }

    /**
     * Является ли заказ покупкой
     *
     * @return bool
     */
    public function isPurchase(): bool
    {
        return $this->type == OrderTypeEnum::Purchase;
    }

    /**
     * Закончился ли срок аренды
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->isRent() && ($this->is_active || now()->greaterThan($this->end_at));
    }
}
