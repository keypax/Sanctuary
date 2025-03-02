<?php

namespace App\Service\Animal\Photo\Uploader\PathGenerator;

use Symfony\Component\String\Slugger\SluggerInterface;

readonly class PathGenerator implements PathGeneratorInterface
{
    public function __construct(
        private SluggerInterface $slugger,
        private string $basePathServer,
        private string $basePathWeb
    ) {}

    public function getServerDirectory(string $animalInternalId, int $year, int $month): string
    {
        return sprintf('%s%s/%s/%s', $this->basePathServer, $year, $month, $this->slugger->slug($animalInternalId));
    }

    public function getWebDirectory(string $animalInternalId, int $year, int $month): string
    {
        return sprintf('%s%s/%s/%s', $this->basePathWeb, $year, $month, $this->slugger->slug($animalInternalId));
    }
}