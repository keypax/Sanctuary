<?php

namespace App\Repository;

use App\Entity\AnimalIdByYear;

interface AnimalIdByYearRepositoryInterface
{
    public function findOneByYear(int $year): ?AnimalIdByYear;
    public function save(AnimalIdByYear $animalIdByYear): void;
}