<?php

namespace App\Exceptions;

use App\Builder\ReturnMessage;
use Exception;

class ApiException extends Exception
{
    protected $code = 400;
    protected $message = "";

    public function render()
    {
        return ReturnMessage::message(true, $this->message, $this->message, $this, null, $this->code);
    }
}
