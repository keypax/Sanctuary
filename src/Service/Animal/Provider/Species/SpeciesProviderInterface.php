<?php

namespace App\Service\Animal\Provider\Species;

use App\Entity\AnimalSpecies;

interface SpeciesProviderInterface
{
    /**
     * @return string[]
     */
    public function getSpecies(): array;
}