<?php

namespace App\Exceptions;

use Exception;

class InvalidOwnerException extends Exception
{
    public function __construct()
    {
        parent::__construct("You are not allowed to access this client", 403);
    }
}
