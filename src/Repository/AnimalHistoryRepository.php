<?php

namespace App\Repository;

use App\Entity\AnimalHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalHistory>
 */
class AnimalHistoryRepository extends ServiceEntityRepository implements AnimalHistoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalHistory::class);
    }
}
