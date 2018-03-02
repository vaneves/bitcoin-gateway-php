<?php

namespace App\Exceptions;

class ValidationException extends AppException
{
    private $messages = [];

    public function __construct($messages)
    {
        parent::__construct($messages[0], 400);
        $this->messages = $messages;
    }

    public function listMessages()
    {
        return $this->messages;
    }
}