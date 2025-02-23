<?php

namespace App\Entity;

use App\Repository\AnimalHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalHistoryRepository::class)]
class AnimalHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalHistory')]
    #[ORM\JoinColumn(name: 'animal_id', referencedColumnName: 'id', nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $before = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $after = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBefore(): ?string
    {
        return $this->before;
    }

    public function setBefore(?string $before): static
    {
        $this->before = $before;

        return $this;
    }

    public function getAfter(): ?string
    {
        return $this->after;
    }

    public function setAfter(?string $after): static
    {
        $this->after = $after;

        return $this;
    }
}
