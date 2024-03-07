<?php

namespace App\Exception;

class InvalidPlayerException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid player');
    }
}
