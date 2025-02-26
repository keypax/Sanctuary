<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Service\Animal\Photo\Deleter\DeleterInterface;
use App\Service\Animal\Photo\Uploader\UploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnimalPhotoService implements AnimalPhotoServiceInterface
{
    function __construct(
        private readonly UploaderInterface $uploader,
        private readonly DeleterInterface $deleter
    ) {

    }

    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): AnimalPhoto
    {
        return $this->uploader->uploadAnimalPhoto($photo, $animal);
    }

    public function deleteAnimalPhoto(AnimalPhoto $photo): void
    {
        $this->deleter->deleteAnimalPhoto($photo);
    }

    public function deleteAnimalPhotos(Animal $animal): void
    {
        $this->deleter->deleteAllAnimalPhotos($animal);
    }
}