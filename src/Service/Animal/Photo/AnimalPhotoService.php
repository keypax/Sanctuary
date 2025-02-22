<?php

namespace App\Service\Animal\Photo;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnimalPhotoService implements AnimalPhotoServiceInterface
{
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): ?AnimalPhoto
    {
        // TODO: Implement uploadAnimalPhoto() method.
    }

    public function deleteAnimalPhoto(AnimalPhoto $photo): void
    {
        // TODO: Implement deleteAnimalPhoto() method.
    }

    public function deleteAnimalPhotos(Animal $animal): void
    {
        // TODO: Implement deleteAnimalPhotos() method.
    }
}