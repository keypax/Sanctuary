<?php /** @noinspection PhpUnused */

namespace App\Repository\AnimalBreed;

use App\Entity\AnimalBreed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimalBreed>
 */
class AnimalBreedRepository extends ServiceEntityRepository implements AnimalBreedRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalBreed::class);
    }

    public function findBySpeciesId(int $speciesId): array
    {
        return $this->findBy(['animalSpecies' => $speciesId]);
    }
}
