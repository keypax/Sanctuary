<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Uploader;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploaderInterface
{
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): ?AnimalPhoto;
}