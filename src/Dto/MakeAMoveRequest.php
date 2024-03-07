<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class MakeAMoveRequest
{
    public int $id;

    #[Assert\Choice([1, 2])]
    public int $player;
    public int $position;
}
