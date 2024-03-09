<?php

namespace App\Service;

use App\Entity\TicTacToeGameSession;
use Doctrine\ORM\EntityManagerInterface;

class TicTacToeSessionService implements TicTacToeSessionServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getGameSessionById(int $id): ?TicTacToeGameSession
    {
        $repo = $this->entityManager->getRepository(TicTacToeGameSession::class);

        return $repo->find($id);
    }

    public function createNewGameSession(): TicTacToeGameSession
    {
        $gameSession = new TicTacToeGameSession();
        $board = [
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ];

        $now = new \DateTimeImmutable();
        $gameSession->setBoard($board)
            ->setCreatedAt($now)
            ->setUpdatedAt($now);

        $this->entityManager->persist($gameSession);
        $this->entityManager->flush();

        return $gameSession;
    }

    public function saveGameSession(TicTacToeGameSession $gameSession): void
    {
        $gameSession->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }
}
