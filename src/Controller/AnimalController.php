<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalRepositoryInterface;
use App\Service\AnimalIdGenerator\AnimalIdGenerationStrategyInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/animal', name: 'animal_')]
class AnimalController extends AbstractController
{
    function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {}

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        AnimalIdGenerationStrategyInterface $nextAnimalIdProvider
    ): Response {
        $animal = new Animal();
        $animal->setAnimalInternalId($nextAnimalIdProvider->proposeNextId());
        $animal->setAdmissionDate(new \DateTimeImmutable('now'));

        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($animal);
                $this->entityManager->flush();

                $nextAnimalIdProvider->incrementId();

                $this->addFlash('success', $this->translator->trans('animal.form.success'));

                return $this->redirectToRoute('animal_index');
            }
            catch (UniqueConstraintViolationException) {
                $this->addFlash('error', $this->translator->trans('animal.form.duplication_error'));

                $form->get('animal_internal_id')->addError(new FormError($this->translator->trans('animal.form.duplication_error')));
            }
        }

        return $this->render('animal/add.html.twig', [
            'form' => $form,
            'animal' => $animal,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        AnimalIdGenerationStrategyInterface $nextAnimalIdProvider,
        string $id
    ): Response {
        $animal = $this->animalRepository->getById($id);

        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($animal);
                $this->entityManager->flush();

                $nextAnimalIdProvider->incrementId();

                $this->addFlash('success', $this->translator->trans('animal.form.success'));

                return $this->redirectToRoute('animal_index');
            }
            catch (UniqueConstraintViolationException) {
                $this->addFlash('error', $this->translator->trans('animal.form.duplication_error'));

                $form->get('animal_internal_id')->addError(new FormError($this->translator->trans('animal.form.duplication_error')));
            }
        }

        return $this->render('animal/edit.html.twig', [
            'form' => $form,
            'animal' => $animal,
        ]);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Animal::class)->findAll();

        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}