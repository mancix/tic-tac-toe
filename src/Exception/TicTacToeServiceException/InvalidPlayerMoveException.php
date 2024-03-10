<?php

namespace App\Exception\TicTacToeServiceException;

class InvalidPlayerMoveException extends \Exception implements TicTacToeServiceExceptionInterface
{
    public const MESSAGE = 'Invalid player move';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
