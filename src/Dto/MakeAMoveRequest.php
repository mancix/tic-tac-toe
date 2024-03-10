<?php

namespace App\Dto;

use App\Exception\TicTacToeServiceException\InvalidPlayerException;
use App\Exception\TicTacToeServiceException\InvalidPositionException;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class MakeAMoveRequest
{
    public function __construct(
        #[Assert\NotBlank(message: 'The game session id is required')]
        #[Assert\Type(type: 'int', message: 'The game session id must be an integer')]
        public int $session_id,

        #[Assert\NotBlank(message: 'The player is required')]
        #[Assert\Choice([1, 2], message: InvalidPlayerException::MESSAGE)]
        public int $player,

        #[Assert\NotBlank(message: 'The position is required')]
        #[Assert\Range(notInRangeMessage: InvalidPositionException::MESSAGE, min: 0, max: 8)]
        public int $position,
    ) {
    }

    public function getSessionId(): int
    {
        return $this->session_id;
    }

    public function getPlayer(): int
    {
        return $this->player;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
