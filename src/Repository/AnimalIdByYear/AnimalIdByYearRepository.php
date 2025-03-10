<?php

namespace App\Repository\AnimalIdByYear;

use App\Entity\AnimalIdByYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalIdByYear>
 */
class AnimalIdByYearRepository extends ServiceEntityRepository implements AnimalIdByYearRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, AnimalIdByYear::class);
    }

    public function save(AnimalIdByYear $animalIdByYear): void
    {
        $this->entityManager->persist($animalIdByYear);
        $this->entityManager->flush();
    }

    public function findOneByYear(int $year): ?AnimalIdByYear
    {
        return $this->findOneBy(["year" => $year]);
    }
}
