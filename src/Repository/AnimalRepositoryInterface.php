<?php

namespace App\Repository;

use App\Entity\Animal;

interface AnimalRepositoryInterface
{
    public function getById($id) : ?Animal;
}