<?php

namespace App\Repository;


use App\Entity\AnimalSpecies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AnimalSpecies>
 */
interface AnimalSpeciesRepositoryInterface
{
    /**
     * @return AnimalSpecies[]
     */
    public function findAll(): array;

    /**
     * @param string $speciesName
     * @return AnimalSpecies|null
     */
    public function findOneBySpeciesName(string $speciesName): ?AnimalSpecies;
}