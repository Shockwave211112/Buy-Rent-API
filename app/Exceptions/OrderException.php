<?php

namespace App\Exceptions;

use Exception;

class OrderException extends Exception
{
    public $status;

    /**
     * @param string $message
     * @param int $status
     */
    public function __construct(string $message = 'Внутренняя ошибка', int $status = 401)
    {
        $this->message = $message;
        $this->status = $status;
    }
}
