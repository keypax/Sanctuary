<?php

namespace App\Service\Animal\Provider\Breed;

use App\Repository\AnimalBreedRepositoryInterface;
use App\Repository\AnimalSpeciesRepositoryInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class BreedsProvider implements BreedsProviderInterface
{
    function __construct(
        private readonly AnimalSpeciesRepositoryInterface $animalSpeciesRepository,
        private readonly AnimalBreedRepositoryInterface $animalBreedRepository,
        private readonly LoggerInterface $logger
    ) {}

    public function getBreeds(string $speciesName): array
    {
        $animalSpecies = $this->animalSpeciesRepository->findOneBySpeciesName($speciesName);
        if (empty($animalSpecies))
        {
            $msg = sprintf("Species not found: %s", $speciesName);
            $this->logger->info($msg);
            throw new InvalidArgumentException($msg);
        }

        $breeds = $this->animalBreedRepository->findBySpeciesId($animalSpecies->getId());
        if (empty($breeds))
        {
            $msg = sprintf("Breeds not found for species: %s", $speciesName);
            $this->logger->info($msg);
            throw new InvalidArgumentException($msg);
        }

        return array_map(function ($breeds) {
            return $breeds->getBreedName();
        }, $breeds);
    }
}