<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/animal', name: 'admin_animal')]
class AnimalController extends AbstractController
{
    #[Route('/add', name: 'admin_animal_add')]
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

    #[Route('/', name: 'admin_animal_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Animal::class)->findAll();

        return $this->render('admin/animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}