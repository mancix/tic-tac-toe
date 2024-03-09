<?php

namespace App\Service;

use App\Entity\TicTacToeGameSession;

interface TicTacToeSessionServiceInterface
{
    public function getGameSessionById(int $id): ?TicTacToeGameSession;

    public function createNewGameSession(): TicTacToeGameSession;

    public function saveGameSession(TicTacToeGameSession $gameSession): void;
}
