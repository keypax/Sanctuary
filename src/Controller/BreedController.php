<?php /** @noinspection PhpUnused */

namespace App\Controller;

use App\Service\Animal\Provider\Breed\BreedsProviderInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/breed', name: 'breed_')]
class BreedController extends AbstractController
{
    function __construct(
        private readonly BreedsProviderInterface $breedsProvider,
    ) {}

    /**
     * @param string $species - needs to be in services.yaml > parameters > breeds
     * @return JsonResponse
     */
    #[Route('/list_by_species/{species}', name: 'breed_list', methods: ['GET'])]
    public function getListBySpecies(string $species): JsonResponse
    {
        try {
            $breeds = $this->breedsProvider->getBreeds($species);
        }
        catch (InvalidArgumentException) {
            return $this->json([]);
        }

        return $this->json($breeds);
    }
}