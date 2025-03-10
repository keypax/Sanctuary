<?php /** @noinspection PhpUnused */

namespace App\Controller;

use App\Repository\Animal\AnimalRepositoryInterface;
use App\Repository\AnimalPhoto\AnimalPhotoRepositoryInterface;
use App\Service\Animal\Photo\AnimalPhotoServiceInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/animal/photo', name: 'animal_photo_')]
class AnimalPhotoController extends AbstractController
{
    public function __construct(
        private readonly AnimalPhotoServiceInterface $animalPhotoService,
        private readonly AnimalPhotoRepositoryInterface $animalPhotoRepository,
        private readonly TranslatorInterface $translator
    ) {}

    #[Route('/add/{animalId}', name: 'add', methods: ['GET', 'POST'])]
    public function add(
        Request $request,
        AnimalRepositoryInterface $animalRepository,
        string $animalId
    ): RedirectResponse
    {
        $animal = $animalRepository->getById($animalId);
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
            $this->animalPhotoRepository->save($photo);

            $this->addFlash('success', $this->translator->trans('animal.photos.upload.success'));
        } catch (Exception) {
            $this->addFlash('error', $this->translator->trans('animal.photos.upload.error'));
        }

        return $this->redirectToRoute('animal_photo_add', ['animalId' => $animal->getId()]);
    }

    #[Route('/delete/{photoId}', name: 'delete', methods: ['POST'])]
    public function delete(
        AnimalPhotoRepositoryInterface $animalPhotoRepository,
        string $photoId
    ): Response
    {
        $photo = $animalPhotoRepository->findById($photoId);
        if (!$photo) {
            $this->addFlash('error', $this->translator->trans('animal.photos.not_found'));
            return $this->redirectToRoute('animal_index');
        }

        $animalId = $photo->getAnimal()->getId();
        try {
            $this->animalPhotoService->deleteAnimalPhotos($photo);
            $this->animalPhotoRepository->remove($photo);

            $this->addFlash('success', $this->translator->trans('animal.photos.delete.success'));
        } catch (Exception) {
            $this->addFlash('error', $this->translator->trans('animal.photos.delete.error'));
        }

        return $this->redirectToRoute('animal_edit', ['id' => $animalId]);
    }
}