<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalSpecies\AnimalSpeciesRepository;
use App\Service\History\HistoryTrackedInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalSpeciesRepository::class)]
class AnimalSpecies implements HistoryTrackedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $speciesName = null;

    #[ORM\OneToMany(targetEntity: AnimalBreed::class, mappedBy: 'animalSpecies', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $animalBreeds;

    public function __construct()
    {
        $this->animalBreeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpeciesName(): ?string
    {
        return $this->speciesName;
    }

    public function setSpeciesName(string $speciesName): static
    {
        $this->speciesName = $speciesName;

        return $this;
    }

    public function addAnimalBreed(AnimalBreed $animalBreed): static
    {
        if (!$this->animalBreeds->contains($animalBreed)) {
            $this->animalBreeds->add($animalBreed);
            $animalBreed->setAnimalSpecies($this);
        }

        return $this;
    }

    public function removeAnimalBreed(AnimalBreed $animalBreed): static
    {
        if ($this->animalBreeds->removeElement($animalBreed)) {
            if ($animalBreed->getAnimalSpecies() === $this) {
                $animalBreed->setAnimalSpecies(null);
            }
        }

        return $this;
    }

    public function getHistoryContext(): string
    {
        return $this->getSpeciesName();
    }
}
