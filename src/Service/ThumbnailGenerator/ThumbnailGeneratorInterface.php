<?php

namespace App\Service\ThumbnailGenerator;

interface ThumbnailGeneratorInterface
{
    /**
     * Generates thumbnails for an image.
     *
     * @param string $originalPath Path to the original image file.
     * @param string $targetDirectory Directory where thumbnails should be saved.
     * @param string $filename Base filename for thumbnails (without size suffixes or extension).
     * @param array $sizes An array of thumbnail sizes, e.g., ['medium' => 500, 'small' => 100].
     * @return void
     */
    public function generateThumbnails(string $originalPath, string $targetDirectory, string $filename, array $sizes): void;
}