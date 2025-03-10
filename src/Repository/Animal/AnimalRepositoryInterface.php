<?php

namespace App\Repository\Animal;

use App\Entity\Animal;

interface AnimalRepositoryInterface
{
    public function getById($id) : ?Animal;

    /**
     * @return Animal[]
     */
    public function findAll() : array;

    public function save(Animal $animal) : void;
}