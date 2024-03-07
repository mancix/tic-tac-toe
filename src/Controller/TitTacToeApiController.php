<?php

namespace App\Controller;

use App\Entity\TicTacToeGameSession;
use App\Service\TicTacToeServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class TitTacToeApiController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TicTacToeServiceInterface $ticTacToeService,
    ) {
    }

    #[Route('/tictactoe', name: 'app_tit_tac_toe_api', methods: ['GET', 'HEAD'])]
    public function index(): JsonResponse
    {
        $repo = $this->entityManager->getRepository(TicTacToeGameSession::class);

        $test = $repo->find(3);

        dump($test);

        /*$test = new TicTacToeGameSession();
        $board = [
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ];

        $test->setBoard($board)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($test);
        $this->entityManager->flush();*/
        return $this->json([
            'message' => $test->getId(),
            'path' => 'src/Controller/TitTacToeApiController.php',
        ]);
    }
}
