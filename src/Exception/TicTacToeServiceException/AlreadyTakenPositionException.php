<?php

namespace App\Exception\TicTacToeServiceException;

class AlreadyTakenPositionException extends \Exception implements TicTacToeServiceExceptionInterface
{
    public const MESSAGE = 'Position already taken';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
