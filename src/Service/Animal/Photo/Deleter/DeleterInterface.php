<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Deleter;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Service\Animal\Photo\Deleter\Exception\DeleterException;

interface DeleterInterface
{
    public function deleteAllAnimalPhotos(Animal $animal): void;

    /**
     * @param AnimalPhoto $photo
     * @return void
     * @throws DeleterException when an error occurs
     */
    public function deleteAnimalPhoto(AnimalPhoto $photo): void;
}