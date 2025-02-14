<?php

namespace App\Service\ThumbnailGenerator;

use App\Service\ThumbnailGenerator\ThumbnailGeneratorInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

class ImagineThumbnailGenerator implements ThumbnailGeneratorInterface
{
    public function __construct(
        private bool $changeExtension,
        private string $targetExtension,
        private Imagine $imagine
    ) {}

    public function generateThumbnails(string $originalPath, string $targetDirectory, string $filename, array $sizes): void
    {
        $originalImage = $this->imagine->open($originalPath);
        $originalWidth = $originalImage->getSize()->getWidth();
        $originalHeight = $originalImage->getSize()->getHeight();

        foreach ($sizes as $sizeName => $maxSize) {
            $thumbnailFilename = pathinfo($filename, PATHINFO_FILENAME) . '_' . $sizeName . '.jpg'; // Fixed extension for thumbnails
            $thumbnailTargetFilename = $targetDirectory . '/' . $thumbnailFilename;
            $this->resize($originalWidth, $originalHeight, $maxSize, $originalImage, $thumbnailTargetFilename);
        }
    }

    private function resize(
        int $originalWidth,
        int $originalHeight,
        int $maxSize,
        ImageInterface $originalImage,
        string $thumbnailTargetFilename,
    ): void
    {
        if ($originalWidth > $originalHeight) {
            $thumbnailWidth = $maxSize;
            $thumbnailHeight = (int) ($originalHeight * ($maxSize / $originalWidth));
        } else {
            $thumbnailHeight = $maxSize;
            $thumbnailWidth = (int) ($originalWidth * ($maxSize / $originalHeight));
        }

        $thumbnailSize = new Box($thumbnailWidth, $thumbnailHeight);
        $thumbnailImage = $originalImage->resize($thumbnailSize);

        if ($this->changeExtension) {
            $thumbnailImage->save($thumbnailTargetFilename, ['format' => $this->targetExtension]);
        }
        else {
            $thumbnailImage->save($thumbnailTargetFilename);
        }
    }
}