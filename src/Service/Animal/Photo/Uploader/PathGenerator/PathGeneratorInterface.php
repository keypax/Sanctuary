<?php

namespace App\Service\Animal\Photo\Uploader\PathGenerator;

use App\Entity\Animal;

interface PathGeneratorInterface
{
    public function getServerDirectory(string $animalInternalId, int $year, int $month): string;
    public function getWebDirectory(string $animalInternalId, int $year, int $month): string;
}