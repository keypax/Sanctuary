<?php

namespace App\Service\AnimalIdGenerator\Strategy;

use App\Entity\AnimalIdByYear;
use App\Repository\AnimalIdByYear\AnimalIdByYearRepositoryInterface;
use App\Service\AnimalIdGenerator\AnimalIdGenerationStrategyInterface;

readonly class YearlySequenceAnimalIdGenerationStrategy implements AnimalIdGenerationStrategyInterface
{
    public function __construct(
        private AnimalIdByYearRepositoryInterface $animalIdByYearRepository,
    ) {}

    /**
     * @return string The next animal id in the format {id}/{year}. Example: 1/2025, 53/2024
     */
    public function proposeNextId(): string
    {
        $animalIdByYear = $this->getAnimalIdByYear();
        if ($animalIdByYear == null) {
            $animalIdByYear = new AnimalIdByYear();
            $animalIdByYear->setYear((int) date("Y"));
            $animalIdByYear->setLastId(1);

            $this->animalIdByYearRepository->save($animalIdByYear);
        }

        return $animalIdByYear->getLastId() . "/" . $animalIdByYear->getYear();
    }

    public function incrementId(): void
    {
        $animalIdByYear = $this->getAnimalIdByYear();
        $animalIdByYear->setLastId($animalIdByYear->getLastId() + 1);

        $this->animalIdByYearRepository->save($animalIdByYear);
    }

    private function getAnimalIdByYear(): ?AnimalIdByYear
    {
        return $this->animalIdByYearRepository->findOneByYear((int) date("Y"));
    }
}