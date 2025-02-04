<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\Table(name: 'animals')]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $animal_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $animal_name = null;

    #[ORM\Column(length: 50)]
    private ?string $species = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birth_date = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $approximate_age = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $distinctive_marks = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $size = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $admission_date = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $adoption_status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $adoption_date = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $chip_number = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    public function getAnimalId(): ?string
    {
        return $this->animal_id;
    }

    public function setAnimalId(string $animal_id): static
    {
        $this->animal_id = $animal_id;

        return $this;
    }

    public function getAnimalName(): ?string
    {
        return $this->animal_name;
    }

    public function setAnimalName(?string $animal_name): static
    {
        $this->animal_name = $animal_name;

        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(string $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTimeInterface $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getApproximateAge(): ?string
    {
        return $this->approximate_age;
    }

    public function setApproximateAge(?string $approximate_age): static
    {
        $this->approximate_age = $approximate_age;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getDistinctiveMarks(): ?string
    {
        return $this->distinctive_marks;
    }

    public function setDistinctiveMarks(?string $distinctive_marks): static
    {
        $this->distinctive_marks = $distinctive_marks;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getAdmissionDate(): ?\DateTimeInterface
    {
        return $this->admission_date;
    }

    public function setAdmissionDate(\DateTimeInterface $admission_date): static
    {
        $this->admission_date = $admission_date;

        return $this;
    }

    public function getAdoptionStatus(): ?int
    {
        return $this->adoption_status;
    }

    public function setAdoptionStatus(?int $adoption_status): static
    {
        $this->adoption_status = $adoption_status;

        return $this;
    }

    public function getAdoptionDate(): ?\DateTimeInterface
    {
        return $this->adoption_date;
    }

    public function setAdoptionDate(?\DateTimeInterface $adoption_date): static
    {
        $this->adoption_date = $adoption_date;

        return $this;
    }

    public function getChipNumber(): ?string
    {
        return $this->chip_number;
    }

    public function setChipNumber(?string $chip_number): static
    {
        $this->chip_number = $chip_number;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }
}
