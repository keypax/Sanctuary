<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalPhotoType;
use App\Form\AnimalType;
use App\Service\AnimalIdGenerator\AnimalIdGenerationStrategyInterface;
use App\Service\AnimalPhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal', name: 'animal_')]
class AnimalController extends AbstractController
{
    function __construct(private AnimalPhotoService $animalPhotoService) {}

    #[Route('/edit/{animal_id}', name: 'edit', defaults: ['animal_id' => null])]
    public function manageAnimal(
        Request                             $request,
        EntityManagerInterface              $entityManager,
        AnimalIdGenerationStrategyInterface $nextAnimalIdProvider,
        string                              $animal_id = null
    ): Response
    {
        $editMode = false;
        if ($animal_id) {
            $animal = $entityManager->getRepository(Animal::class)->findOneBy(["animal_id" => $animal_id]);
            $editMode = true;

            if (!$animal) {
                throw $this->createNotFoundException('Animal not found');
            }
        } else {
            $animal = new Animal();
            $animal->setAnimalId($nextAnimalIdProvider->proposeNextId());
        }

        $form = $this->createForm(AnimalType::class, $animal);
        $formPhoto = $this->createForm(AnimalPhotoType::class);

        $form->handleRequest($request);
        $formPhoto->handleRequest($request);
        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $photo = $formPhoto->get('photo')->getData();
            if ($photo) {
                $animalPhoto = $this->animalPhotoService->uploadAnimalPhoto($photo, $animal);

                if (!$animalPhoto) {
                    $this->addFlash('error', 'Nie udało się zapisać zdjęcia.');
                    return $this->redirectToRoute('animal_index');
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $currentAnimalId = $animal->getAnimalId();

            //change "/" to "-"
            if ($currentAnimalId) {
                $newAnimalId = str_replace('/', '-', $currentAnimalId);
                $animal->setAnimalId($newAnimalId);
            }

            if (!$editMode)
            {
                $nextAnimalIdProvider->incrementId();
            }

            $entityManager->persist($animal);
            $entityManager->flush();

            //$this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('animal_index');
        }

        return $this->render('animal/edit.html.twig', [
            'form' => $form->createView(),
            'form_photo' => $formPhoto->createView(),
            'animal' => $animal ?? null,
            'edit_mode' => $editMode,
        ]);
    }

    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Animal::class)->findAll();

        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}