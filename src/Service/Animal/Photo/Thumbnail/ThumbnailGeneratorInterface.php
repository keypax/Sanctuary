<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Thumbnail;

interface ThumbnailGeneratorInterface
{
    /**
     * Generates thumbnails for an image.
     *
     * @param string $originalFilepath Path to the original image file.
     * @param string $targetDirectory Directory where thumbnails should be saved.
     * @param string $targetFilename Base filename for thumbnails (without size suffixes or extension).
     * @param ThumbnailSize $thumbnailSize Size of the thumbnail to generate.
     * @return string
     */
    public function generateThumbnails(string $originalFilepath, string $targetDirectory, string $targetFilename, ThumbnailSize $thumbnailSize): string;
}