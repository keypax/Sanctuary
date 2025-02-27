<?php

namespace App\Service\FileUploader;

use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    /**
     * Uploads a file to the target directory and returns the web path to the file.
     *
     * @param UploadedFile $file
     * @param string $targetDirectory Server path where the file should be moved.
     * @param string $newFilename The new filename to use.
     * @return string The web path to the uploaded file (e.g., /uploads/...).
     * @throws FileException if something goes wrong during upload.
     */
    public function upload(UploadedFile $file, string $targetDirectory, string $newFilename): string;

    /**
     * Creates a directory if it does not exist.
     *
     * @param string $targetDirectory
     * @throws Exception
     */
    public function createDirectory(string $targetDirectory): void;
}