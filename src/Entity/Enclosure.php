<?php

namespace App\Entity;

use App\Repository\Enclosure\EnclosureRepository;
use App\Service\History\HistoryTrackedInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnclosureRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_enclosure_name', columns: ['enclosure_name'])]
class Enclosure implements HistoryTrackedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $enclosure_name = null;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'enclosure')]
    private Collection $animal;

    public function __construct()
    {
        $this->animal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnclosureName(): ?string
    {
        return $this->enclosure_name;
    }

    public function setEnclosureName(string $enclosure_name): static
    {
        $this->enclosure_name = $enclosure_name;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimal(): Collection
    {
        return $this->animal;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animal->contains($animal)) {
            $this->animal->add($animal);
            $animal->setEnclosure($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animal->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getEnclosure() === $this) {
                $animal->setEnclosure(null);
            }
        }

        return $this;
    }

    public function getHistoryContext(): string
    {
        return $this->getEnclosureName();
    }
}
