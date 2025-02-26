<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Uploader;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploaderInterface
{
    /**
     * @param UploadedFile $photo
     * @param Animal $animal
     * @return AnimalPhoto thumbnail filename
     * @throws Exception if error occurs during thumbnail generation
     */
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): AnimalPhoto;
}