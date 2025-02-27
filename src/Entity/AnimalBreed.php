<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalBreedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalBreedRepository::class)]
class AnimalBreed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $breedName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: AnimalSpecies::class, inversedBy: 'animalBreeds')]
    #[ORM\JoinColumn(name: 'animal_species_id', referencedColumnName: 'id', nullable: false)]
    private ?AnimalSpecies $animalSpecies = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreedName(): ?string
    {
        return $this->breedName;
    }

    public function setBreedName(string $breedName): static
    {
        $this->breedName = $breedName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAnimalSpecies(): ?AnimalSpecies
    {
        return $this->animalSpecies;
    }

    public function setAnimalSpecies(?AnimalSpecies $animalSpecies): void
    {
        $this->animalSpecies = $animalSpecies;
    }
}
