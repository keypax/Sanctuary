<?php

namespace App\Service\Animal\Provider\Species;

interface SpeciesProviderInterface
{
    /**
     * @return string[]
     */
    public function getSpecies(): array;
}