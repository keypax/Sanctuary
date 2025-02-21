<?php

namespace App\Repository;

use App\Entity\AnimalPhoto;

interface AnimalPhotoRepositoryInterface
{
    public function findById(string $id): ?AnimalPhoto;
}