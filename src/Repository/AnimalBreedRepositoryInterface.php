<?php

namespace App\Repository;

use App\Entity\AnimalBreed;

interface AnimalBreedRepositoryInterface
{
    /**
     * @param int $speciesId
     * @return AnimalBreed[]
     */
    public function findBySpeciesId(int $speciesId): array;
}