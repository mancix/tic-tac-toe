<?php

namespace App\Service;

use App\Exception\TicTacToeServiceException\AlreadyTakenPositionException;
use App\Exception\TicTacToeServiceException\GameOverException;
use App\Exception\TicTacToeServiceException\InvalidPlayerException;
use App\Exception\TicTacToeServiceException\InvalidPlayerMoveException;
use App\Exception\TicTacToeServiceException\InvalidPositionException;

interface TicTacToeServiceInterface
{
    /**
     * @return array<int|null>[]
     *
     * @throws InvalidPositionException|InvalidPlayerException|AlreadyTakenPositionException|GameOverException|InvalidPlayerMoveException
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
    public function restoreGame(array $board, ?int $lastPlayer): static;

    /**
     * @return int|null 1|2|null
     */
    public function getLastPlayer(): ?int;

    /**
     * @return int|null $last_player
     */
    public function getWinner(): ?int;
}
