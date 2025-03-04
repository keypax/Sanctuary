<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service\Animal\Photo\Deleter;

use App\Entity\Animal;
use App\Entity\AnimalPhoto;
use App\Repository\AnimalPhotoRepositoryInterface;
use App\Service\Animal\Photo\Deleter\Deleter;
use App\Service\Animal\Photo\Deleter\Exception\DeleterException;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class DeleterTest extends TestCase
{
    private MockObject $logger;
    private MockObject $repository;

    private string $basePathServer;
    private string $serverFilePath;
    private Deleter $deleter;

    protected function setUp(): void {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->repository = $this->createMock(AnimalPhotoRepositoryInterface::class);
        $this->basePathServer = sys_get_temp_dir();

        $this->deleter = new Deleter(
            $this->logger,
            $this->repository,
            $this->basePathServer
        );
    }

    protected function tearDown(): void {
        if (file_exists($this->serverFilePath)) {
            unlink($this->serverFilePath);
        }
    }

    private function prepareAnimalPhotoMock(int $id, string $filenameOriginal): AnimalPhoto {
        $photo = $this->createMock(AnimalPhoto::class);
        $photo->method("getId")->willReturn($id);
        $photo->method("getFilenameOriginal")->willReturn($filenameOriginal);

        return $photo;
    }

    private function createTemporaryFile(): string {
        $fileName = 'deleter_test_'.uniqid().'.jpg';
        $this->serverFilePath = $this->basePathServer . DIRECTORY_SEPARATOR . $fileName;
        file_put_contents($this->serverFilePath, 'dummy');

        return $fileName;
    }

    public function testDeleteAnimalPhoto(): void {
        $fileName = $this->createTemporaryFile();
        $photo = $this->prepareAnimalPhotoMock(1, $fileName);
        $this->repository->expects($this->once())->method("remove");
        $this->deleter->deleteAnimalPhoto($photo);

        $this->assertFileDoesNotExist($this->serverFilePath);
    }

    public function testDeleteAnimalPhotoThrowsNotFoundException(): void {
        $fileName = $this->createTemporaryFile();
        $photo = $this->prepareAnimalPhotoMock(1, $fileName . 'blablabla');
        $this->expectException(DeleterException::class);
        $this->repository->expects($this->never())->method("remove");
        $this->deleter->deleteAnimalPhoto($photo);

        $this->assertFileDoesNotExist($this->serverFilePath);
    }

    public function testDeleteAllAnimalPhotos(): void {
        $fileName1 = $this->createTemporaryFile();
        $photo1 = $this->prepareAnimalPhotoMock(1, $fileName1);

        $fileName2 = $this->createTemporaryFile();
        $photo2 = $this->prepareAnimalPhotoMock(2, $fileName2);

        $animal = $this->createMock(Animal::class);
        $animal->method("getAnimalPhoto")->willReturn(new ArrayCollection([$photo1, $photo2]));

        $this->repository->expects($this->exactly(2))->method("remove");
        $this->deleter->deleteAllAnimalPhotos($animal);
    }

    public function testDeleteAllAnimalPhotosOneThrowsException(): void {
        $fileName1 = $this->createTemporaryFile();
        $photo1 = $this->prepareAnimalPhotoMock(1, $fileName1);

        $fileName2 = $this->createTemporaryFile();
        $photo2 = $this->prepareAnimalPhotoMock(2, $fileName2 . "blablabla");

        $animal = $this->createMock(Animal::class);
        $animal->method("getAnimalPhoto")->willReturn(new ArrayCollection([$photo1, $photo2]));

        $this->repository->expects($this->exactly(1))->method("remove");
        $this->logger->expects($this->atLeastOnce())->method("error")->with($this->stringContains("Photo not found"));
        $this->deleter->deleteAllAnimalPhotos($animal);
    }
}