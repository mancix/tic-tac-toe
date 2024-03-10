<?php

namespace App\Service;

use App\Exception\TicTacToeServiceException\AlreadyTakenPositionException;
use App\Exception\TicTacToeServiceException\GameOverException;
use App\Exception\TicTacToeServiceException\InvalidPlayerException;
use App\Exception\TicTacToeServiceException\InvalidPlayerMoveException;
use App\Exception\TicTacToeServiceException\InvalidPositionException;

class TicTacToeService implements TicTacToeServiceInterface
{
    /**
     * @var array<int|null>[]
     */
    private array $board = [
        [null, null, null],
        [null, null, null],
        [null, null, null],
    ];

    /**
     * @var int|null 1|2|null
     */
    private ?int $player = null;

    public function makeAMove(int $player, int $position): array
    {
        if (null !== $this->getWinner()) {
            throw new GameOverException();
        }

        if (1 !== $player && 2 !== $player) {
            throw new InvalidPlayerException();
        }

        if (null !== $this->player && $player === $this->player) {
            throw new InvalidPlayerMoveException();
        }

        if ($position >= 0 && $position <= 8) {
            $this->player = $player;
            $row = (int) ($position / 3);
            $column = $position % 3;
            if (null === $this->board[$row][$column]) {
                $this->board[$row][$column] = $player;
            } else {
                throw new AlreadyTakenPositionException();
            }

            return $this->board;
        }

        throw new InvalidPositionException();
    }

    public function getNumberOfRemainingMoves(): int
    {
        $numberOfMoves = 0;
        foreach ($this->board as $row) {
            foreach ($row as $column) {
                if (null === $column) {
                    ++$numberOfMoves;
                }
            }
        }

        return $numberOfMoves;
    }

    /**
     * @return array<int|null>[]
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @return int|null 1|2|null
     */
    public function getWinner(): ?int
    {
        $winner = null;
        $rows = $this->board;
        $columns = $this->getColumns($this->board);
        $diagonals = $this->getDiagonals($this->board);

        foreach ($rows as $row) {
            $winner = $this->getWinnerFromRow($row);
            if (null !== $winner) {
                return $winner;
            }
        }

        foreach ($columns as $column) {
            $winner = $this->getWinnerFromRow($column);
            if (null !== $winner) {
                return $winner;
            }
        }

        foreach ($diagonals as $diagonal) {
            $winner = $this->getWinnerFromRow($diagonal);
            if (null !== $winner) {
                return $winner;
            }
        }

        return $winner;
    }

    /**
     * @param array<int|null>[] $board
     *
     * @return array<int|null>[]
     */
    private function getColumns(array $board): array
    {
        $columns = [];
        for ($i = 0; $i < 3; ++$i) {
            $column = [];
            for ($j = 0; $j < 3; ++$j) {
                $column[] = $board[$j][$i];
            }
            $columns[] = $column;
        }

        return $columns;
    }

    /**
     * @param array<int|null>[] $board
     *
     * @return array<int|null>[]
     */
    private function getDiagonals(array $board): array
    {
        return [
            [$board[0][0], $board[1][1], $board[2][2]],
            [$board[0][2], $board[1][1], $board[2][0]],
        ];
    }

    /**
     * @param array<int|null> $row
     */
    private function getWinnerFromRow(array $row): ?int
    {
        if (!empty($row[0] && !empty($row[1]) && !empty($row[2]) && $row[0] === $row[1] && $row[1] === $row[2])) {
            return $row[0];
        }

        return null;
    }

    /**
     * @param array<int|null>[] $board
     */
    public function restoreGame(array $board, ?int $lastPlayer): static
    {
        $this->board = $board;
        $this->player = $lastPlayer;

        return $this;
    }

    /**
     * @return int|null 1|2|null
     */
    public function getLastPlayer(): ?int
    {
        return $this->player;
    }
}
