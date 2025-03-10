<?php

declare(strict_types=1);

namespace App\Repository\AnimalSpecies;

use App\Entity\AnimalSpecies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalSpecies>
 */
class AnimalSpeciesRepository extends ServiceEntityRepository implements AnimalSpeciesRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalSpecies::class);
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function findOneBySpeciesName(string $speciesName): ?AnimalSpecies
    {
        return $this->findOneBy(['speciesName' => $speciesName]);
    }
}
