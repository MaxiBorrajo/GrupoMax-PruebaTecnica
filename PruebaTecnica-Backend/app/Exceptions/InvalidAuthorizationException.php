<?php

namespace App\Exceptions;

use Exception;

class InvalidAuthorizationException extends Exception
{
    public function __construct() {
        parent::__construct("Invalid authorization/authentication", 401);
    }
}
