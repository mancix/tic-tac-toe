<?php

namespace App\Controller;

use App\Dto\MakeAMoveRequest;
use App\Exception\GameOverException;
use App\Exception\GameSessionNotFound;
use App\Service\TicTacToeServiceInterface;
use App\Service\TicTacToeSessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class TitTacToeApiController extends AbstractController
{
    public function __construct(
        private TicTacToeSessionServiceInterface $ticTacToeSessionService,
        private TicTacToeServiceInterface $ticTacToeService,
    ) {
    }

    #[Route('/new_game', name: 'new-game-api', methods: ['POST'])]
    public function createNewGame(): JsonResponse
    {
        $newSession = $this->ticTacToeSessionService->createNewGameSession();

        return $this->json([
            'sessionId' => $newSession->getId(),
        ], 201);
    }

    /**
     * @param MakeAMoveRequest $makeAMoveRequest
     *
     * @throws GameOverException
     * @throws GameSessionNotFound
     */
    #[Route('/move', name: 'make-a-move-api', methods: ['POST'])]
    public function makeAMove(#[MapRequestPayload] MakeAMoveRequest $makeAMoveRequest): JsonResponse
    {
        $gameSession = $this->ticTacToeSessionService->getGameSessionById($makeAMoveRequest->getId());
        if (null === $gameSession) {
            throw new GameSessionNotFound();
        }

        $this->ticTacToeService->restoreGame($gameSession->getBoard(), $gameSession->getLastPlayer());
        if (0 === $this->ticTacToeService->getNumberOfRemainingMoves()) {
            throw new GameOverException();
        }
        $board = $this->ticTacToeService->makeAMove($makeAMoveRequest->getPlayer(), $makeAMoveRequest->getPosition());
        $gameSession->setBoard($board);
        $gameSession->setLastPlayer($this->ticTacToeService->getLastPlayer());
        $this->ticTacToeSessionService->saveGameSession($gameSession);

        return $this->json([
            'board' => $board,
            'winner' => $this->ticTacToeService->getWinner(),
        ]);
    }
}
