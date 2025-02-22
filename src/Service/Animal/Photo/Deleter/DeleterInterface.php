<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Deleter;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;

interface DeleterInterface
{
    public function deleteAllAnimalPhotos(Animal $animal): void;
    public function deleteAnimalPhoto(AnimalPhoto $photo): void;
}