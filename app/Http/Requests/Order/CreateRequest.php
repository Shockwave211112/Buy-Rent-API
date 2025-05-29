<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderTypeEnum;
use App\Enums\RentVariantsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * @OA\Schema(
 *      schema="CreateOrderRequest",
 *      required={"product_id", "type"},
 *      @OA\Property(
 *          property="product_id",
 *          type="integer",
 *          example="1"
 *      ),
 *     @OA\Property(
 *          property="type",
 *          type="string",
 *          example="rent | purchase"
 *      ),
 *     @OA\Property(
 *          property="time",
 *          type="integer",
 *          example="4 | 8 | 12 | 24"
 *      )
 * )
 */
class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'type' => ['required', Rule::enum(OrderTypeEnum::class)],
            'time' => ['required_if:type,rent', Rule::enum(RentVariantsEnum::class)],
        ];
    }
}
