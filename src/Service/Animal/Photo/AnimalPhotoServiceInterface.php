<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AnimalPhotoServiceInterface
{
    /**
     * @param UploadedFile $photo
     * @param Animal $animal
     * @return AnimalPhoto
     * @throws Exception if error occurs during thumbnail generation
     */
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): AnimalPhoto;
    public function deleteAnimalPhoto(AnimalPhoto $photo): void;
    public function deleteAnimalPhotos(Animal $animal): void;
}