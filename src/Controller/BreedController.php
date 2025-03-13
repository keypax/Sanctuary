<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace App\Controller;

use App\Repository\AnimalBreed\AnimalBreedRepositoryInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/breed', name: 'breed_')]
class BreedController extends AbstractController
{
    public function __construct(
        private readonly AnimalBreedRepositoryInterface $animalBreedRepository,
    ) {}

    /**
     * @param int $speciesId
     * @return JsonResponse
     */
    #[Route('/list_by_species/{speciesId}', name: 'breed_list', methods: ['GET'])]
    public function getListBySpecies(int $speciesId): JsonResponse
    {
        $breeds = $this->animalBreedRepository->findBySpeciesId($speciesId);

        //return only breedName and id
        $breeds = array_map(function($breed) {
            return [
                'id' => $breed->getId(),
                'breedName' => $breed->getBreedName()
            ];
        }, $breeds);

        return $this->json($breeds);
    }
}