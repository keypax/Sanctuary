<?php

namespace App\Service\Animal\Provider\Species;

use App\Repository\AnimalSpecies\AnimalSpeciesRepositoryInterface;

readonly class SpeciesProvider implements SpeciesProviderInterface
{
    public function __construct(
        private AnimalSpeciesRepositoryInterface $animalSpeciesRepository
    ) {}

    public function getSpecies(): array
    {
        return array_map(function ($species) {
            return $species->getSpeciesName();
        }, $this->animalSpeciesRepository->findAll());
    }
}