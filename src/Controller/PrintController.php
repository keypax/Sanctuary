<?php

namespace App\Controller;

use App\Repository\Animal\AnimalRepositoryInterface;
use App\Service\Animal\Choice\ChoicesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/print', name: 'print_')]
class PrintController extends AbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private string $qrCodeTargetUrl
    ) { }

    #[Route('/internal/{id}', name: 'internal', methods: ['GET'])]
    public function internal(
        int $id,
        ChoicesServiceInterface $choicesService
    ): Response {
        $animal = $this->animalRepository->getById($id);

        return $this->render('print/internal.html.twig', [
            'animal' => $animal,
            'qrCodeTargetUrl' => $this->qrCodeTargetUrl,
            'choicesService' => $choicesService,
        ]);
    }
}