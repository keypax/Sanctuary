<?php

namespace App\Repository;

use App\Entity\Animal;
use App\Entity\AnimalHistory;

interface AnimalHistoryRepositoryInterface
{
    /**
     * @param Animal $animal
     * @return AnimalHistory[]
     */
    public function findLatestForAnimal(Animal $animal, int $limit): array;
}