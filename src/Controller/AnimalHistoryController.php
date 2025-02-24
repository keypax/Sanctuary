<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalHistoryRepositoryInterface;
use App\Repository\AnimalRepositoryInterface;
use App\Service\AnimalIdGenerator\AnimalIdGenerationStrategyInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal_history', name: 'animal_history_')]
class AnimalHistoryController extends AbstractController
{
    #[Route('/show/{animalId}', name: 'show', methods: ['GET'])]
    public function new(
        string $animalId,
        Request $request,
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