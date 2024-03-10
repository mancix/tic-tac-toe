<?php

namespace App\Exception\TicTacToeServiceException;

class InvalidPositionException extends \Exception implements TicTacToeServiceExceptionInterface
{
    public const MESSAGE = 'The position on the board must be between 0 and 8';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
