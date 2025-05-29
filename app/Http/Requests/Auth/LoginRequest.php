<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      schema="LoginRequest",
 *      required={"email", "password"},
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="example@mail.com"
 *      ),
 *     @OA\Property(
 *          property="password",
 *          type="string",
 *          example="password"
 *      ),
 * )
 */
class LoginRequest extends FormRequest
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
            'email' => 'required|email|string|exists:users,email',
            'password' => 'required|min:8|string',
        ];
    }
}
