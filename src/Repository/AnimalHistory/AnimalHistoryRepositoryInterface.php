<?php

namespace App\Repository\AnimalHistory;

use App\Entity\Animal;
use App\Entity\AnimalHistory;

interface AnimalHistoryRepositoryInterface
{
    /**
     * @param Animal $animal
     * @param int $limit
     * @return AnimalHistory[]
     */
    public function findLatestForAnimal(Animal $animal, int $limit): array;

    /**
     * @param Animal $animal
     * @return AnimalHistory[]
     */
    public function findAllForAnimal(Animal $animal): array;
}