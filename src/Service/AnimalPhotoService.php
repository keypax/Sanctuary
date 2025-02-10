<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use Doctrine\ORM\EntityManagerInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AnimalPhotoService
{
    public function __construct(
        private Filesystem $filesystem,
        private SluggerInterface $slugger,
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator,
        private LoggerInterface $logger,
        private string $basePathServer,
        private string $basePathWeb,
        private int $thumbnailMaxSizeMedium,
        private int $thumbnailMaxSizeSmall,
        private bool $changeExtension,
        private string $targetExtension,
        private Imagine $imagine = new Imagine()
    ) { }

    /**
     * @throws \Exception - when creating directory fails
     */
    public function uploadAnimalPhoto(UploadedFile $photo, Animal $animal): ?AnimalPhoto
    {
        $year = date('Y');
        $month = date('m');

        $targetServerDirectory = $this->basePathServer . $year . '/' . $month . '/' . $animal->getAnimalId();
        $targetWebDirectory = $this->basePathWeb . $year . '/' . $month . '/' . $animal->getAnimalId();

        $this->createDirectory($targetServerDirectory);

        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $this->getNewFilename($safeFilename, $photo);
        $originalPath = $targetServerDirectory . '/' . $newFilename;

        try {
            $photo->move($targetServerDirectory, $newFilename);

            $imageSize = getimagesize($originalPath);
            $width = $imageSize[0];
            $height = $imageSize[1];
            $fileSize = filesize($originalPath);

            $animalPhoto = new AnimalPhoto();
            $animalPhoto->setAnimal($animal);
            $animalPhoto->setFilename($targetWebDirectory . '/' . $newFilename);
            $animalPhoto->setWidth($width);
            $animalPhoto->setHeight($height);
            $animalPhoto->setSize($fileSize);

            $this->generateThumbnails($originalPath, $targetServerDirectory, $newFilename);

            $this->entityManager->persist($animalPhoto);
            $this->entityManager->flush();

            return $animalPhoto;

        } catch (FileException $e) {

            $this->logger->error('Error uploading photo: ' . $e->getMessage());
            throw $e;
        }
    }

    private function generateThumbnails(string $originalPath, string $targetDirectory, string $filename): void
    {
        $originalImage = $this->imagine->open($originalPath);
        $originalWidth = $originalImage->getSize()->getWidth();
        $originalHeight = $originalImage->getSize()->getHeight();

        $mediumFilename = pathinfo($filename, PATHINFO_FILENAME) . '_medium.jpg';
        $mediumTargetFilename = $targetDirectory . '/' . $mediumFilename;
        $mediumMaxSize = $this->thumbnailMaxSizeMedium;

        $this->resize($originalWidth, $originalHeight, $mediumMaxSize, $originalImage, $mediumTargetFilename);

        $thumbnailFilename = pathinfo($filename, PATHINFO_FILENAME) . '_small.jpg';
        $thumbnailTargetFilename = $targetDirectory . '/' . $thumbnailFilename;
        $thumbnailMaxSize = $this->thumbnailMaxSizeSmall;

        $this->resize($originalWidth, $originalHeight, $thumbnailMaxSize, $originalImage, $thumbnailTargetFilename);
    }

    private function resize(
        int $originalWidth,
        int $originalHeight,
        int $mediumMaxSize,
        ImageInterface $originalImage,
        string $mediumTargetFilename,
    ): void
    {
        if ($originalWidth > $originalHeight) {
            $mediumWidth = $mediumMaxSize;
            $mediumHeight = (int)($originalHeight * ($mediumMaxSize / $originalWidth));
        } else {
            $mediumHeight = $mediumMaxSize;
            $mediumWidth = (int)($originalWidth * ($mediumMaxSize / $originalHeight));
        }

        $mediumSize = new Box($mediumWidth, $mediumHeight);
        $mediumImage = $originalImage->resize($mediumSize);

        if ($this->changeExtension) {
            $mediumImage->save($mediumTargetFilename, ['format' => $this->targetExtension]);
        }
        else {
            $mediumImage->save($mediumTargetFilename);
        }
    }

    private function getNewFilename(AbstractUnicodeString $safeFilename, UploadedFile $photo): string
    {
        if ($this->changeExtension) {
            $newFilename = $safeFilename . '-' . uniqid() . $this->targetExtension;
        } else {
            $newFilename = $safeFilename . '-' . uniqid() . $photo->guessExtension();
        }

        return $newFilename;
    }

    /**
     * @param string $targetDirectory
     * @return void
     * @throws \Exception
     */
    private function createDirectory(string $targetDirectory): void
    {
        try {
            $this->filesystem->mkdir($targetDirectory, 0755);
        } catch (\Exception $e) {
            throw new \Exception($this->translator->trans('error_creating_directory'));
        }
    }
}