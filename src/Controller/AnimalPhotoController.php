<?php

namespace App\Controller;

use App\Repository\AnimalRepositoryInterface;
use App\Service\AnimalPhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/animal/photo', name: 'animal_photo_')]
class AnimalPhotoController extends AbstractController
{
    public function __construct(
        private AnimalPhotoService $animalPhotoService,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    )
    {

    }

    #[Route('/add/{id}', name: 'add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        AnimalRepositoryInterface $animalRepository,
        string $id
    )
    {
        $animal = $animalRepository->getById($id);
        if (!$animal)
        {
            throw $this->createNotFoundException($this->translator->trans('animal.form.not_found'));
        }

        $uploadedFile = $request->files->get('photo');
        if (!$uploadedFile) {
            $this->addFlash('error', $this->translator->trans('animal.photo.no_file'));
            return $this->redirectToRoute('animal_edit', ['id' => $animal->getId()]);
        }

        try {
            $photo = $this->animalPhotoService->uploadAnimalPhoto($uploadedFile, $animal);
            $this->entityManager->persist($photo);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('animal.photo.upload.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $this->translator->trans('animal.photo.upload.error'));
        }

        return $this->redirectToRoute('animal_photo_add', ['id' => $animal->getId()]);
    }
}