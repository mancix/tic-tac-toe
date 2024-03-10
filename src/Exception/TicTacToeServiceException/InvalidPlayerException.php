<?php

namespace App\Exception\TicTacToeServiceException;

class InvalidPlayerException extends \Exception implements TicTacToeServiceExceptionInterface
{
    public const MESSAGE = 'The player must be 1 or 2';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
