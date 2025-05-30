<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *       schema="ProductsListPaginated",
 *       @OA\Property(
 *           property="data",
 *           type="array",
 *           @OA\Items(ref="#/components/schemas/Product")
 *       ),
 *       @OA\Property(
 *          property="links",
 *          type="object",
 *          @OA\Property(
 *              property="first",
 *              type="string",
 *              example="http://host/api/products?page=1"
 *          ),
 *          @OA\Property(
 *              property="last",
 *              type="string",
 *              example="http://host/api/products?page=2"
 *          ),
 *          @OA\Property(
 *              property="prev",
 *              type="string",
 *              example="null | http://host/api/products?page=1"
 *          ),
 *          @OA\Property(
 *              property="next",
 *              type="string",
 *              example="null | http://host/api/products?page=2"
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
 *                              example="null | http://host/api/products?page=2"
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
 *                  example="http://host/api/products"
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
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function orders(): HasMany {
        return $this->hasMany(Order::class);
    }
}
