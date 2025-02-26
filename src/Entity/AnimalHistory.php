<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalHistoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalHistoryRepository::class)]
#[ORM\Table(
    name: 'animal_history',
    indexes: [
        new ORM\Index(name: 'animal_history_animal_id_idx', columns: ['animal_id', 'id']),
        new ORM\Index(name: 'animal_history_user_id_idx', columns: ['user_id', 'id']),
    ]
)]
class AnimalHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalHistory')]
    #[ORM\JoinColumn(name: 'animal_id', referencedColumnName: 'id', nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'animalHistory')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $datetime;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getDatetime(): DateTimeImmutable
    {
        return $this->datetime;
    }

    public function setDatetime(DateTimeImmutable $datetime): void
    {
        $this->datetime = $datetime;
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
