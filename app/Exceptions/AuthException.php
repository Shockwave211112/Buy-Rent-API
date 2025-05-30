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
    public function __construct(string $message = null, int $status = 401)
    {
        $this->message = $message ?? __('errors.auth');
        $this->status = $status;
    }
}
