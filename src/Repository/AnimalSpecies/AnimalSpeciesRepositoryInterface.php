<?php

namespace App\Repository\AnimalSpecies;


use App\Entity\AnimalSpecies;
use App\Repository\AnimalSpecies\Exception\AnimalSpeciesNotFoundException;
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
}