<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Deleter;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Repository\AnimalPhoto\AnimalPhotoRepositoryInterface;
use App\Service\Animal\Photo\Deleter\Exception\DeleterException;
use Exception;
use Psr\Log\LoggerInterface;

readonly class Deleter implements DeleterInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private AnimalPhotoRepositoryInterface $animalPhotoRepository,
        private string $basePathServer
    ) { }

    public function deleteAllAnimalPhotos(Animal $animal): void
    {
        $photos = $animal->getAnimalPhoto();

        foreach ($photos as $photo) {
            try {
                $this->deleteAnimalPhoto($photo);
            } catch (DeleterException $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    public function deleteAnimalPhoto(AnimalPhoto $photo): void
    {
        $serverFilePath = $this->basePathServer  . DIRECTORY_SEPARATOR . $photo->getFilenameOriginal();

        try {
            if (file_exists($serverFilePath)) {
                if (unlink($serverFilePath)) {
                    $this->logger->info('Photo deleted: ' . $serverFilePath);
                } else {
                    throw new DeleterException('Error deleting photo: ' . $serverFilePath);
                }
            } else {
                throw new DeleterException('Photo not found: ' . $serverFilePath);
            }
        } catch (Exception $e) {
            throw new DeleterException('Error deleting photo: ' . $e->getMessage(), $e->getCode(), $e);
        }

        $this->animalPhotoRepository->remove($photo);

        $this->logger->info('Photo entity removed: ' . $photo->getId());
    }
}