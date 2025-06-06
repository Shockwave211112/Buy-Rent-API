<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthException) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
                $exception->status
            );
        }
        if ($exception instanceof OrderException) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
                $exception->status
            );
        }
        if ($exception instanceof DatabaseException) {
            return response()->json(
                [
                    'message' => $exception->getMessage(),
                ],
                $exception->status
            );
        }
        return parent::render($request, $exception);
    }
}
