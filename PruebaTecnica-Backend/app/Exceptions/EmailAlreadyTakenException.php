<?php

namespace App\Exceptions;

use Exception;

class EmailAlreadyTakenException extends Exception
{
    public function __construct()
    {
        parent::__construct("Email already taken", 400);
    }

}