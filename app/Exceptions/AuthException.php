<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    public $status;

    /**
     * @param string $message
     * @param int $status
     */
    public function __construct(string $message = 'Ошибка авторизации', int $status = 401)
    {
        $this->message = $message;
        $this->status = $status;
    }
}
