<?php

namespace App\Repository;

use App\Entity\Enclosure;

interface EnclosureRepositoryInterface
{
    /**
     * @return Enclosure[]
     */
    public function findAll(): array;
}