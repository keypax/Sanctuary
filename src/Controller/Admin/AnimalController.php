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
    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animal();

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', 'Animal created successfully!');

            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{animal_id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, string $animal_id): Response
    {
        $animal = $entityManager->getRepository(Animal::class)->findBy("animal_id", $animal_id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal not found');
        }

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); // W przypadku edycji nie używamy persist(), bo obiekt jest już zarządzany przez Doctrine

            $this->addFlash('success', 'Animal updated successfully!');

            return $this->redirectToRoute('admin_animal_index');
        }

        return $this->render('admin/animal/edit.html.twig', [
            'form' => $form->createView(),
            'animal' => $animal, // Możesz przekazać zwierzę do szablonu, jeśli potrzebujesz wyświetlić np. tytuł "Edycja zwierzęcia: ..."
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