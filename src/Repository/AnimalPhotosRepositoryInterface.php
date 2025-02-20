<?php

namespace App\Repository;

use App\Entity\AnimalPhoto;

interface AnimalPhotosRepositoryInterface
{
    public function getById(string $id): ?AnimalPhoto;
}