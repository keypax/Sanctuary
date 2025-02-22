<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Uploader;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploaderInterface
{
    /**
     * @param string $originalServerPath
     * @param string $targetServerDirectory
     * @param string $newFilename
     * @return string thumbnail filename
     */
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): AnimalPhoto;
}