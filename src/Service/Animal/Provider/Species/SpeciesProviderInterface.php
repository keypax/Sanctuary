<?php

namespace App\Service\Animal\Provider\Species;

use App\Entity\AnimalSpecies;

interface SpeciesProviderInterface
{
    /**
     * @return AnimalSpecies[]
     */
    public function getSpecies(): array;
}