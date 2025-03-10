<?php

namespace App\Repository\Enclosure;

use App\Entity\Enclosure;

interface EnclosureRepositoryInterface
{
    /**
     * @return Enclosure[]
     */
    public function findAll(): array;
}