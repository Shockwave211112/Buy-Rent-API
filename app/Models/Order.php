<?php

namespace App\Models;

use App\Enums\OrderTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->isRent() && now()->greaterThan($this->end_at);
    }
}
