<?php

namespace App\Service\AnimalIdProvider;

use App\Entity\AnimalIdByYear;
use Doctrine\ORM\EntityManagerInterface;

class YearlySeqAnimalProvider implements NextAnimalIdProviderInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    /**
     * @return string The next animal id in the format {id}/{year}. Example: 1/2025, 53/2024
     */
    public function getNextId(): string
    {
        $animalIdByYear = $this->getAnimalIdByYear();
        if ($animalIdByYear == null) {
            $animalIdByYear = new AnimalIdByYear();
            $animalIdByYear->setYear(date("Y"));
            $animalIdByYear->setLastId(1);

            $this->entityManager->persist($animalIdByYear);
            $this->entityManager->flush();
        }

        return $animalIdByYear->getLastId() . "/" . $animalIdByYear->getYear();
    }

    public function incrementId(): void
    {
        $animalIdByYear = $this->getAnimalIdByYear();
        $animalIdByYear->setLastId($animalIdByYear->getLastId() + 1);

        $this->entityManager->persist($animalIdByYear);
        $this->entityManager->flush();
    }

    private function getAnimalIdByYear(): ?AnimalIdByYear
    {
        return $this->entityManager->getRepository(AnimalIdByYear::class)->findOneBy(["year" => date("Y")]);
    }
}