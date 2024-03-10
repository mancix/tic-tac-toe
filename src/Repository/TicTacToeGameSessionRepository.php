<?php

namespace App\Repository;

use App\Entity\TicTacToeGameSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TicTacToeGameSession>
 *
 * @method TicTacToeGameSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicTacToeGameSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicTacToeGameSession[]    findAll()
 * @method TicTacToeGameSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicTacToeGameSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TicTacToeGameSession::class);
    }
}
