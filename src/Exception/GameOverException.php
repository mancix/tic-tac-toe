<?php

namespace App\Exception;

class GameOverException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Game is over');
    }
}
