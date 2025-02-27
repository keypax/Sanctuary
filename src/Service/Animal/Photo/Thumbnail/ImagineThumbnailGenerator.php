<?php

declare(strict_types=1);

namespace App\Service\Animal\Photo\Thumbnail;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

readonly class ImagineThumbnailGenerator implements ThumbnailGeneratorInterface
{
    public function __construct(
        private bool $changeExtension,
        private string $targetExtension,
        private Imagine $imagine
    ) {}

    public function generateThumbnails(string $originalFilepath, string $targetDirectory, string $targetFilename, ThumbnailSize $thumbnailSize): string
    {
        $originalImage = $this->imagine->open($originalFilepath);
        $originalWidth = $originalImage->getSize()->getWidth();
        $originalHeight = $originalImage->getSize()->getHeight();

        $thumbnailFilename = $this->getThumbnailFilename($targetFilename, $thumbnailSize);
        $thumbnailTargetFilename = $targetDirectory . '/' . $thumbnailFilename;
        $this->resize($originalWidth, $originalHeight, $thumbnailSize->value, $originalImage, $thumbnailTargetFilename);

        return $thumbnailFilename;
    }

    private function resize(
        int $originalWidth,
        int $originalHeight,
        int $maxSize,
        ImageInterface $originalImage,
        string $thumbnailTargetFilename,
    )
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

    /**
     * @param string $targetFilename
     * @param ThumbnailSize $thumbnailSize
     * @return string
     */
    private function getThumbnailFilename(string $targetFilename, ThumbnailSize $thumbnailSize): string
    {
        return pathinfo($targetFilename, PATHINFO_FILENAME) . '_' . strtolower($thumbnailSize->name) . '.' . $this->targetExtension;
    }
}