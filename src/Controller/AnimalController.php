<?php /** @noinspection PhpUnused */

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Repository\AnimalHistoryRepositoryInterface;
use App\Repository\AnimalRepositoryInterface;
use App\Service\AnimalIdGenerator\AnimalIdGenerationStrategyInterface;
use DateTimeImmutable;
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
        private readonly AnimalRepositoryInterface $animalRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator
    ) {}

    /** @noinspection PhpRedundantCatchClauseInspection */
    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        AnimalIdGenerationStrategyInterface $nextAnimalIdProvider
    ): Response {
        $animal = new Animal();
        $animal->setAnimalInternalId($nextAnimalIdProvider->proposeNextId());
        $animal->setAdmissionDate(new DateTimeImmutable('now'));

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

    /** @noinspection PhpRedundantCatchClauseInspection */
    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        AnimalIdGenerationStrategyInterface $nextAnimalIdProvider,
        AnimalHistoryRepositoryInterface $animalHistoryRepository,
        string $id
    ): Response {
        $animal = $this->animalRepository->getById($id);
        $animalHistories = $animalHistoryRepository->findLatestForAnimal($animal, 10);

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
            'animal_histories' => $animalHistories
        ]);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $animals = $this->animalRepository->findAll();

        return $this->render('animal/index.html.twig', [
            'animals' => $animals,
        ]);
    }
}