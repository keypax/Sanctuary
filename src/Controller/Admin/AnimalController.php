<?php

namespace App\Controller\Admin;

use App\Form\AnimalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/animal', name: 'admin_animal')]
class AnimalController extends AbstractController
{
    #[Route('/add', name: 'admin_animal_add')]
    public function add(): Response
    {
        $form = $this->createForm(AnimalType::class);

        return $this->render('admin/animal/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}