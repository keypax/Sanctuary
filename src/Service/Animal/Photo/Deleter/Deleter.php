<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Deleter;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

readonly class Deleter implements DeleterInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private string $basePathServer,
        private string $basePathWeb
    ) { }

    public function deleteAllAnimalPhotos(Animal $animal): void
    {
        $photos = $animal->getAnimalPhoto();

        foreach ($photos as $photo) {
            $this->deleteAnimalPhoto($photo);
        }
    }

    public function deleteAnimalPhoto(AnimalPhoto $photo): void
    {
        $serverFilePath = str_replace($this->basePathWeb, $this->basePathServer, $photo->getFilenameOriginal());

        try {
            if (file_exists($serverFilePath)) {
                if (unlink($serverFilePath)) {
                    $this->logger->info('Photo deleted: ' . $serverFilePath);
                } else {
                    $this->logger->warning('Error deleting photo: ' . $serverFilePath);
                }
            } else {
                $this->logger->warning('Photo not found: ' . $serverFilePath);
            }
        } catch (Exception $e) {
            $this->logger->error('Error deleting photo: ' . $e->getMessage());
        }

        $this->entityManager->remove($photo);
        $this->entityManager->flush();

        $this->logger->info('Photo entity removed: ' . $photo->getId());
    }
}