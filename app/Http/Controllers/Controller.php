<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Buy-Rent API",
 *    description="...",
 *    version="1.0.0",
 * )
 * @OA\Schema(
 *      schema="MessageResponse",
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="Информация"
 *      )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
