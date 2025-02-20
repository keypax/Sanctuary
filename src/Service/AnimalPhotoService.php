<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Service\FileUploader\FileUploaderInterface;
use App\Service\ThumbnailGenerator\ThumbnailGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AnimalPhotoService
{
    public function __construct(
        private FileUploaderInterface $fileUploader,
        private ThumbnailGeneratorInterface $thumbnailGenerator,
        private SluggerInterface $slugger,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private LoggerInterface $logger,
        private string $basePathServer,
        private string $basePathWeb,
        private array $thumbnailSizes,
        private bool $changeExtension,
        private string $targetExtension
    ) { }

    /**
     * @throws \Exception - when creating directory fails
     */
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): ?AnimalPhoto
    {
        $year = date('Y');
        $month = date('m');

        $targetServerDirectory = $this->basePathServer . $year . '/' . $month . '/' . $animal->getAnimalId();
        $targetWebDirectory = $this->basePathWeb . $year . '/' . $month . '/' . $animal->getAnimalId();

        $this->fileUploader->createDirectory($targetServerDirectory);

        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $this->getNewFilename($safeFilename, $photo);
        $originalPath = $targetServerDirectory . '/' . $newFilename;

        $originalServerPath = $this->fileUploader->upload($photo, $targetServerDirectory, $newFilename);

        try {
            $imageSize = getimagesize($originalPath);
            $width = $imageSize[0];
            $height = $imageSize[1];
            $fileSize = filesize($originalPath);

            $animalPhoto = new AnimalPhoto();
            $animalPhoto->setAnimal($animal);
            $animalPhoto->setFilename($targetWebDirectory . '/' . $newFilename);
            $animalPhoto->setWidth($width);
            $animalPhoto->setHeight($height);
            $animalPhoto->setSize($fileSize);

            $this->thumbnailGenerator->generateThumbnails( // Use ThumbnailGenerator service
                $originalServerPath,
                $targetServerDirectory,
                pathinfo($newFilename, PATHINFO_FILENAME), // Pass filename without extension for thumbnails
                $this->thumbnailSizes // Pass thumbnail sizes configuration
            );

            $this->entityManager->persist($animalPhoto);
            $this->entityManager->flush();

            return $animalPhoto;

        } catch (FileException $e) {

            $this->logger->error('Error uploading photo: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteAnimalPhoto(AnimalPhoto $photo): void
    {
        //todo
    }


    private function getNewFilename(AbstractUnicodeString $safeFilename, UploadedFile $photo): string
    {
        if ($this->changeExtension) {
            $newFilename = $safeFilename . '-' . uniqid() . "." . $this->targetExtension;
        } else {
            $newFilename = $safeFilename . '-' . uniqid() . "." . $photo->guessExtension();
        }

        return $newFilename;
    }
}