<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    protected $message = 'Credenciais inválidas';
    protected $code = 401;

    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->code);
    }
}