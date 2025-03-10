<?php

namespace App\Repository\Animal;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository implements AnimalRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Animal::class);
    }

    public function getById($id): ?Animal
    {
        return $this->find($id);
    }

    /**
     * @param Animal $animal
     * @return void
     * @throws UniqueConstraintViolationException if the animal with the same internal ID already exists
     */
    public function save(Animal $animal): void
    {
        $this->entityManager->persist($animal);
        $this->entityManager->flush();
    }
}
