<?php

namespace App\Repository;

use App\Entity\AnimalPhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalPhoto>
 */
class AnimalPhotoRepository extends ServiceEntityRepository implements AnimalPhotoRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalPhoto::class);
    }

    public function findById(string $id): ?AnimalPhoto
    {
        return $this->find($id);
    }
}
