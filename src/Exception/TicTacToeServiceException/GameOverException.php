<?php

namespace App\Exception\TicTacToeServiceException;

class GameOverException extends \Exception implements TicTacToeServiceExceptionInterface
{
    public const MESSAGE = 'Game is over';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
