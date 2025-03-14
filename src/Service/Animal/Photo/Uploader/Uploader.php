<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Uploader;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Repository\AnimalPhoto\AnimalPhotoRepositoryInterface;
use App\Service\Animal\Photo\Thumbnail\ThumbnailGeneratorInterface;
use App\Service\Animal\Photo\Thumbnail\ThumbnailSize;
use App\Service\Animal\Photo\Uploader\PathGenerator\PathGenerator;
use App\Service\FileUploader\FileUploaderInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class Uploader implements UploaderInterface
{
    public function __construct(
        private PathGenerator $pathGenerator,
        private FileUploaderInterface $fileUploader,
        private SluggerInterface $slugger,
        private ThumbnailGeneratorInterface $thumbnailGenerator,
        private AnimalPhotoRepositoryInterface $animalPhotoRepository,
        private LoggerInterface $logger,
        private bool $changeExtension,
        private string $targetExtension
    ) {}

    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): AnimalPhoto
    {
        $year = (int) date('Y');
        $month = (int) date('m');

        $targetServerDirectory = $this->pathGenerator->getServerDirectory($animal->getAnimalInternalId(), $year, $month);
        $targetWebDirectory = $this->pathGenerator->getWebDirectory($animal->getAnimalInternalId(), $year, $month);

        $this->createDirectory($targetServerDirectory);

        $newFilename = $this->getNewFilename($photo);
        $originalPath = $targetServerDirectory . '/' . $newFilename;

        $originalServerPath = $this->fileUploader->upload($photo, $targetServerDirectory, $newFilename);

        try {
            $imageSize = getimagesize($originalPath);
            $width = $imageSize[0];
            $height = $imageSize[1];
            $fileSize = filesize($originalPath);

            $animalPhoto = new AnimalPhoto();
            $animalPhoto->setAnimal($animal);
            $animalPhoto->setFilenameOriginal($targetWebDirectory . '/' . $newFilename);

            foreach (ThumbnailSize::cases() as $thumbnailSize) {
                $thumbnailFilename = $this->generateThumbnail($originalServerPath, $targetServerDirectory, $newFilename, $thumbnailSize);
                $setter = $animalPhoto->getSetterForThumbnail($thumbnailSize->name);
                $animalPhoto->$setter($targetWebDirectory . "/" . $thumbnailFilename);
            }

            $animalPhoto->setWidth($width);
            $animalPhoto->setHeight($height);
            $animalPhoto->setSize($fileSize);

            $this->animalPhotoRepository->save($animalPhoto);

            return $animalPhoto;

        } catch (FileException $e) {

            $this->logger->error('Error uploading photo: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param UploadedFile $photo
     * @return string
     */
    private function getNewFilename(UploadedFile $photo): string
    {
        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        if ($this->changeExtension) {
            $newFilename = $safeFilename . '-' . uniqid() . "." . $this->targetExtension;
        } else {
            $newFilename = $safeFilename . '-' . uniqid() . "." . $photo->guessExtension();
        }

        return $newFilename;
    }

    private function generateThumbnail(string $originalServerPath, string $targetServerDirectory, string $newFilename, ThumbnailSize $thumbnailSize): string
    {
        return $this->thumbnailGenerator->generateThumbnails(
            $originalServerPath,
            $targetServerDirectory,
            pathinfo($newFilename, PATHINFO_FILENAME),
            $thumbnailSize
        );
    }

    /**
     * @param string $targetServerDirectory
     * @return void
     * @throws Exception
     */
    private function createDirectory(string $targetServerDirectory): void
    {
        try {
            $this->fileUploader->createDirectory($targetServerDirectory);
        } catch (Exception $e) {
            $this->logger->error('Error creating directory: ' . $e->getMessage());
            throw $e;
        }
    }
}