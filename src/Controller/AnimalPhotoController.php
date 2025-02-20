<?php

namespace App\Controller;

use App\Entity\AnimalPhoto;
use App\Repository\AnimalPhotosRepositoryInterface;
use App\Repository\AnimalRepositoryInterface;
use App\Service\AnimalPhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/animal/photo', name: 'animal_photo_')]
class AnimalPhotoController extends AbstractController
{
    public function __construct(
        private AnimalPhotoService $animalPhotoService,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {}

    #[Route('/add/{animalRepositoryId}', name: 'add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        AnimalRepositoryInterface $animalRepository,
        string $animalRepositoryId
    )
    {
        $animal = $animalRepository->getById($animalRepositoryId);
        if (!$animal)
        {
            throw $this->createNotFoundException($this->translator->trans('animal.photos.not_found'));
        }

        $uploadedFile = $request->files->get('photo');
        if (!$uploadedFile) {
            $this->addFlash('error', $this->translator->trans('animal.photos.no_file'));
            return $this->redirectToRoute('animal_edit', ['id' => $animal->getId()]);
        }

        try {
            $photo = $this->animalPhotoService->uploadAnimalPhoto($uploadedFile, $animal);
            $this->entityManager->persist($photo);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('animal.photos.upload.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $this->translator->trans('animal.photos.upload.error'));
        }

        return $this->redirectToRoute('animal_photo_add', ['animalRepositoryId' => $animal->getId()]);
    }

    #[Route('/delete/{photoId}', name: 'delete', methods: ['POST'])]
    public function delete(
        AnimalPhotosRepositoryInterface $animalPhotosRepository,
        string $photoId
    ): Response
    {
        $photo = $animalPhotosRepository->getById($photoId);
        $animalRepositoryId = $photo->getAnimal()->getId();

        if (!$photo) {
            $this->addFlash('error', $this->translator->trans('animal.photos.not_found'));
            return $this->redirectToRoute('animal_index');
        }

        try {
            $this->animalPhotoService->deleteAnimalPhoto($photo);
            $this->entityManager->remove($photo);
            $this->entityManager->flush();

            $this->addFlash('success', $this->translator->trans('animal.photos.delete.success'));
        } catch (\Exception $e) {
            $this->addFlash('error', $this->translator->trans('animal.photos.delete.error'));
        }

        return $this->redirectToRoute('animal_edit', ['id' => $animalRepositoryId]);
    }
}