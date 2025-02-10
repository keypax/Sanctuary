<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Form\AnimalPhotoType;
use App\Form\AnimalType;
use App\Service\AnimalPhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/animal', name: 'admin_animal_')]
class AnimalController extends AbstractController
{
    function __construct(private AnimalPhotoService $animalPhotoService)
    {

    }

    #[Route('/edit/{animal_id}', name: 'edit', defaults: ['animal_id' => null])]
    public function manageAnimal(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, string $animal_id = null): Response
    {
        $editMode = false;
        if ($animal_id) {
            $animal = $entityManager->getRepository(Animal::class)->findOneBy(["animal_id" => $animal_id]);
            $editMode = true;

            if (!$animal) {
                throw $this->createNotFoundException('Animal not found');
            }

            $flashMessage = 'Animal updated successfully!';
        } else {
            $animal = new Animal();
            $flashMessage = 'Animal created successfully!';
        }

        $form = $this->createForm(AnimalType::class, $animal);
        $formPhoto = $this->createForm(AnimalPhotoType::class);

        $form->handleRequest($request);
        $formPhoto->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //change "/" to "-"
            $currentAnimalId = $animal->getAnimalId();

            if ($currentAnimalId) {
                $newAnimalId = str_replace('/', '-', $currentAnimalId);
                $animal->setAnimalId($newAnimalId);
            }

            $photo = $formPhoto->get('photo')->getData();
            if ($photo) {
                $animalPhoto = $this->animalPhotoService->uploadAnimalPhoto($photo, $animal);

                if (!$animalPhoto) {
                    $this->addFlash('error', 'Nie udało się zapisać zdjęcia.');
                    return $this->redirectToRoute('admin_animal_index');
                }
            }

            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/edit.html.twig', [
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

        return $this->render('admin/animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}