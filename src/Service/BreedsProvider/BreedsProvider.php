<?php

namespace App\Service\BreedsProvider;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class BreedsProvider implements BreedsProviderInterface
{
    function __construct(
        private LoggerInterface $logger,
        private array $allBreeds
    ) {}

    /**
     * @param string $species - species of animal that is declared in services.yaml
     * @return array
     */
    public function getBreeds(string $species): array
    {
        if (array_key_exists($species, $this->allBreeds)) {
            return $this->allBreeds[$species];
        }

        $this->logger->info('Breeds not found for species: ' . $species);
        throw new InvalidArgumentException('Breeds not found for species: ' . $species);
    }
}