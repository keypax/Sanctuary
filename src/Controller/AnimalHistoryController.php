<?php /** @noinspection PhpUnused */

namespace App\Controller;

use App\Repository\Animal\AnimalRepositoryInterface;
use App\Repository\AnimalHistory\AnimalHistoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal_history', name: 'animal_history_')]
class AnimalHistoryController extends AbstractController
{
    #[Route('/show/{animalId}', name: 'show', methods: ['GET'])]
    public function new(
        string $animalId,
        AnimalRepositoryInterface $animalRepository,
        AnimalHistoryRepositoryInterface $animalHistoryRepository,
    ): Response {
        $animal = $animalRepository->getById($animalId);
        $animalHistories = $animalHistoryRepository->findAllForAnimal($animal);

        return $this->render('animal/history/show.html.twig', [
            'animal' => $animal,
            'animalHistories' => $animalHistories,
        ]);
    }
}