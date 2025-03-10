<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalPhoto\AnimalPhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

#[ORM\Entity(repositoryClass: AnimalPhotoRepository::class)]
class AnimalPhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filenameOriginal = null;

    #[ORM\Column(length: 255)]
    private ?string $filenameBig = null;
    #[ORM\Column(length: 255)]
    private ?string $filenameMedium = null;
    #[ORM\Column(length: 255)]
    private ?string $filenameSmall = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $width = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $height = null;

    #[ORM\ManyToOne(inversedBy: 'animalPhoto')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column]
    private ?int $size = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilenameOriginal(): ?string
    {
        return $this->filenameOriginal;
    }

    public function setFilenameOriginal(string $filenameOriginal): static
    {
        $this->filenameOriginal = $filenameOriginal;

        return $this;
    }

    public function getFilenameBig(): ?string
    {
        return $this->filenameBig;
    }

    public function setFilenameBig(string $filenameBig): static
    {
        $this->filenameBig = $filenameBig;

        return $this;
    }

    public function getFilenameMedium(): ?string
    {
        return $this->filenameMedium;
    }

    public function setFilenameMedium(string $filenameMedium): static
    {
        $this->filenameMedium = $filenameMedium;

        return $this;
    }

    public function getFilenameSmall(): ?string
    {
        return $this->filenameSmall;
    }

    public function setFilenameSmall(string $filenameSmall): static
    {
        $this->filenameSmall = $filenameSmall;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function getSetterForThumbnail(string $thumbnailSize): string
    {
        $setter = 'setFilename' . $thumbnailSize;
        if (!method_exists($this, $setter)) {
            throw new LogicException('Method ' . $setter . ' does not exist in AnimalPhoto entity');
        }

        return $setter;
    }
}
