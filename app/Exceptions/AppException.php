<?php

namespace App\Exceptions;

class AppException extends \Exception
{
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }
}