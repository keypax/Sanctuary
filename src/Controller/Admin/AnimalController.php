<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/animal', name: 'admin_animal_')]
class AnimalController extends AbstractController
{
    #[Route('/edit/{animal_id}', name: 'edit', defaults: ['animal_id' => null])]
    public function manageAnimal(Request $request, EntityManagerInterface $entityManager, string $animal_id = null): Response
    {
        if ($animal_id) {
            $animal = $entityManager->getRepository(Animal::class)->findOneBy(["animal_id" => $animal_id]);

            if (!$animal) {
                throw $this->createNotFoundException('Animal not found');
            }

            $flashMessage = 'Animal updated successfully!';
        } else {
            $animal = new Animal();
            $flashMessage = 'Animal created successfully!';
        }

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', $flashMessage);

            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/edit.html.twig', [
            'form' => $form->createView(),
            'animal' => $animal ?? null,
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