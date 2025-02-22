<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Deleter;

use App\Entity\AnimalPhoto;
use App\Service\Animal\Photo\Deleter\DeleterInterface;

class Deleter implements DeleterInterface
{

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
        } catch (\Exception $e) {
            $this->logger->error('Error deleting photo: ' . $e->getMessage());
        }

        $this->entityManager->remove($photo);
        $this->entityManager->flush();

        $this->logger->info('Photo entity removed: ' . $photo->getId());
    }
}