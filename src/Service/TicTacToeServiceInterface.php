<?php

namespace App\Service;

interface TicTacToeServiceInterface
{
    /**
     * @return array<int|null>[]
     */
    public function makeAMove(int $player, int $position): array;

    public function getNumberOfRemainingMoves(): int;

    /**
     * @return array<int|null>[]
     */
    public function getBoard(): array;

    /**
     * @param array<int|null>[] $board
     */
    public function setBoard(array $board): static;

    /**
     * @return int|null 1|2|null
     */
    public function getLastPlayer(): ?int;

    /**
     * @return int|null $last_player
     */
    public function getWinner(): ?int;
}
