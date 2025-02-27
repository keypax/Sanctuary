<?php

namespace App\Repository;

use App\Entity\AnimalPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalPhoto>
 */
class AnimalPhotoRepository extends ServiceEntityRepository implements AnimalPhotoRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, AnimalPhoto::class);
    }

    public function findById(string $id): ?AnimalPhoto
    {
        return $this->find($id);
    }

    public function save(AnimalPhoto $photo): void
    {
        $this->entityManager->persist($photo);
        $this->entityManager->flush();
    }

    public function remove(AnimalPhoto $photo): void
    {
        $this->entityManager->remove($photo);
        $this->entityManager->flush();
    }
}
