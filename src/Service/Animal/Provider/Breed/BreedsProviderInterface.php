<?php

namespace App\Service\Animal\Provider\Breed;

use InvalidArgumentException;

interface BreedsProviderInterface
{
    /**
     * @param string $speciesName
     * @throws InvalidArgumentException - if breeds not found for species
     * @return array
     */
    public function getBreeds(string $speciesName): array;
}