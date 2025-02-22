<?php

namespace App\Service\Animal\Photo;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AnimalPhotoServiceInterface
{
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): ?AnimalPhoto;
    public function deleteAnimalPhoto(AnimalPhoto $photo): void;
    public function deleteAnimalPhotos(Animal $animal): void;
}