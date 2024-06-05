<?php

namespace App\Repository;

use App\Entity\VideoGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<VideoGame> */
class VideoGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoGame::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('videogame')
            ->orderBy('videogame.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneById(int $id): ?VideoGame
    {
        return $this->createQueryBuilder('videogame')
            ->where('videogame.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
