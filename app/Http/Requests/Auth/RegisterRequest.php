<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      schema="RegisterRequest",
 *      required={"email", "password", "password_confirmation", "name"},
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="example@mail.com"
 *      ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Example"
 *      ),
 *     @OA\Property(
 *          property="password",
 *          type="string",
 *          example="password"
 *      ),
 *     @OA\Property(
 *          property="password_confirmation",
 *          type="string",
 *          example="password"
 *      ),
 * )
 */
class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|string',
            'password_confirmation' => 'required|min:8|string|same:password',
        ];
    }
}
