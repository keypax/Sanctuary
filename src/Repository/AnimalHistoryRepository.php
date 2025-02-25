<?php

namespace App\Repository;

use App\Entity\Animal;
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

    public function findLatestForAnimal(Animal $animal, int $limit): array
    {
        return $this->createQueryBuilder('ah')
            ->andWhere('ah.animal = :animal')
            ->setParameter('animal', $animal)
            ->orderBy('ah.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findAllForAnimal(Animal $animal): array
    {
        return $this->createQueryBuilder('ah')
            ->andWhere('ah.animal = :animal')
            ->setParameter('animal', $animal)
            ->orderBy('ah.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
