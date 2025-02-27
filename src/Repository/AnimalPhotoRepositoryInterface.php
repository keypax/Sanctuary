<?php

namespace App\Repository;

use App\Entity\AnimalPhoto;

interface AnimalPhotoRepositoryInterface
{
    public function findById(string $id): ?AnimalPhoto;
    public function save(AnimalPhoto $photo): void;
    public function remove(AnimalPhoto $photo): void;
}