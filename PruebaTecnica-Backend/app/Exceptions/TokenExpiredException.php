<?php

namespace App\Exceptions;

use Exception;

class TokenExpiredException extends Exception
{
    public function __construct()
    {
        parent::__construct("Token expired", 400);
    }
}
