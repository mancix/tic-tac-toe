<?php

namespace App\Entity;

use App\Repository\TicTacToeGameSessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicTacToeGameSessionRepository::class)]
class TicTacToeGameSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var array<int|null>[]
     */
    #[ORM\Column(type: Types::JSON)]
    private array $board = [];

    #[ORM\Column(nullable: true)]
    private ?int $last_player = null;

    #[ORM\Column(nullable: true)]
    private ?int $winner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return array<int|null>[]
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @param array<int|null>[] $board
     */
    public function setBoard(array $board): static
    {
        $this->board = $board;

        return $this;
    }

    public function getLastPlayer(): ?int
    {
        return $this->last_player;
    }

    public function setLastPlayer(?int $last_player): static
    {
        $this->last_player = $last_player;

        return $this;
    }

    public function getWinner(): ?int
    {
        return $this->winner;
    }

    public function setWinner(?int $winner): static
    {
        $this->winner = $winner;

        return $this;
    }
}
