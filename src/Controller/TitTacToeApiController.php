<?php

namespace App\Controller;

use App\Dto\MakeAMoveRequest;
use App\Service\TicTacToeServiceInterface;
use App\Service\TicTacToeSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tic_tac_toe', name: 'tic-tac-toe-api')]
class TitTacToeApiController extends AbstractController
{
    public function __construct(
        private TicTacToeSessionService $ticTacToeSessionService,
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

    // https://symfony.com/doc/current/controller/error_pages.html#overriding-the-default-errorcontroller
    // https://symfony.com/blog/new-in-symfony-6-3-mapping-request-data-to-typed-objects?utm_source=Symfony%20Blog%20Feed&utm_medium=feed
    #[Route('/move', name: 'make-a-move-api', methods: ['POST'])]
    public function makeAMove(#[MapRequestPayload] MakeAMoveRequest $makeAMoveRequest): JsonResponse
    {
        $gameSession = $this->ticTacToeSessionService->getGameSessionById($makeAMoveRequest->id);
        if (null === $gameSession) {
            return $this->json([
                'error' => 'Game session not found',
            ], 404);
        }

        $this->ticTacToeService->restoreGame($gameSession->getBoard(), $gameSession->getLastPlayer());
        if (0 === $this->ticTacToeService->getNumberOfRemainingMoves()) {
            return $this->json([
                'error' => 'Game over',
            ], 400);
        }
        $board = $this->ticTacToeService->makeAMove($makeAMoveRequest->player, $makeAMoveRequest->position);
        $gameSession->setBoard($board);
        $gameSession->setLastPlayer($this->ticTacToeService->getLastPlayer());
        $this->ticTacToeSessionService->saveGameSession($gameSession);

        return $this->json([
            'board' => $board,
            'winner' => $this->ticTacToeService->getWinner(),
        ]);
    }
}
