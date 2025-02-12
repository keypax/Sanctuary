<?php

namespace App\Controller;

use App\Service\BreedsProvider\BreedsProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    function __construct(private readonly BreedsProviderInterface $breedsProvider) {}

    #[Route('/breeds/{species}', name: 'breeds')]
    public function getBreeds(string $species): JsonResponse
    {
        $breeds = $this->breedsProvider->getBreeds($species);

        return $this->json($breeds);
    }
}