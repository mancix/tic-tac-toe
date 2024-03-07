<?php

namespace App\Exception;

class AlreadyTakenPositionException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Position already taken');
    }
}
