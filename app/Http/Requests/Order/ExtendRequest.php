<?php

namespace App\Http\Requests\Order;

use App\Enums\RentVariantsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      schema="ExtendOrderRequest",
 *      required={"product_id", "type"},
 *      @OA\Property(
 *          property="time",
 *          type="integer",
 *          example="4 | 8 | 12 | 24"
 *      )
 * )
 */
class ExtendRequest extends FormRequest
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
            'time' => ['required_if:type,rent', Rule::enum(RentVariantsEnum::class)],
        ];
    }
}
