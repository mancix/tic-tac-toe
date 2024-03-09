<?php

namespace App\Dto;

use App\Exception\InvalidPlayerException;
use App\Exception\InvalidPositionException;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class MakeAMoveRequest
{
    #[Assert\NotBlank(message: 'The game session id is required')]
    #[Assert\Type(type: 'int', message: 'The game session id must be an integer')]
    private int $id;

    #[Assert\NotBlank(message: 'The player is required')]
    #[Assert\Choice([1, 2], message: InvalidPlayerException::MESSAGE)]
    private int $player;

    #[Assert\NotBlank(message: 'The position is required')]
    #[Assert\Range(notInRangeMessage: InvalidPositionException::MESSAGE, min: 0, max: 8)]
    private int $position;

    public function __construct(int $id, int $player, int $position)
    {
        $this->id = $id;
        $this->player = $player;
        $this->position = $position;
    }

    public function getId(): int
    {
        return $this->id;
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
