<?php

namespace App\Service\FileUploader;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class LocalFileSystemUploader implements FileUploaderInterface
{
    public function __construct(
        private Filesystem $filesystem,
        private TranslatorInterface $translator,
        private LoggerInterface $logger
    ) {}

    /**
     * @inheritDoc
     */
    public function upload(UploadedFile $file, string $targetDirectory, string $newFilename): string
    {
        $file->move($targetDirectory, $newFilename);
        return $targetDirectory . '/' . $newFilename;
    }

    /**
     * @inheritDoc
     */
    public function createDirectory(string $targetDirectory): void
    {
        try {
            $this->filesystem->mkdir($targetDirectory, 0755);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw new Exception($this->translator->trans('error_creating_directory'));
        }
    }
}