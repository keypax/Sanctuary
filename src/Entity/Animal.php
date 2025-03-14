<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\Animal\AnimalRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_animal_internal_id', columns: ['animal_internal_id'])]
#[ORM\HasLifecycleCallbacks()]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $animal_internal_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $animal_name = null;

    #[ORM\ManyToOne]
    private ?AnimalSpecies $species = null;

    #[ORM\ManyToOne]
    private ?AnimalBreed $breed = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0])]
    private ?int $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $birth_date = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $approximate_age = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $distinctive_marks = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $size = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $admission_date = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $adoption_status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $adoption_date = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $chip_number = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    #[ORM\OneToMany(targetEntity: AnimalPhoto::class, mappedBy: 'animal', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $animalPhoto;

    /** @var Collection<int, AnimalHistory> */
    #[ORM\OneToMany(targetEntity: AnimalHistory::class, mappedBy: 'animal', cascade: ['persist'], orphanRemoval: true)]
    private Collection $animalHistory;

    #[ORM\ManyToOne(inversedBy: 'animal')]
    private ?Enclosure $enclosure = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: false)]
    private ?DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->animalPhoto = new ArrayCollection();
        $this->animalHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimalInternalId(): ?string
    {
        return $this->animal_internal_id;
    }

    public function setAnimalInternalId(string $animal_internal_id): static
    {
        $this->animal_internal_id = $animal_internal_id;

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

    public function getSpecies(): ?AnimalSpecies
    {
        return $this->species;
    }

    public function setSpecies(?AnimalSpecies $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getBreed(): ?AnimalBreed
    {
        return $this->breed;
    }

    public function setBreed(?AnimalBreed $breed): static
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

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(?DateTimeInterface $birth_date): static
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getApproximateAge(): ?int
    {
        return $this->approximate_age;
    }

    public function setApproximateAge(?int $approximate_age): static
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

    public function getAdmissionDate(): ?DateTimeInterface
    {
        return $this->admission_date;
    }

    public function setAdmissionDate(DateTimeInterface $admission_date): static
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

    public function getAdoptionDate(): ?DateTimeInterface
    {
        return $this->adoption_date;
    }

    public function setAdoptionDate(?DateTimeInterface $adoption_date): static
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

    /**
     * @return Collection<int, AnimalPhoto>
     */
    public function getAnimalPhoto(): Collection
    {
        return $this->animalPhoto;
    }

    public function addAnimalPhoto(AnimalPhoto $animalPhoto): static
    {
        if (!$this->animalPhoto->contains($animalPhoto)) {
            $this->animalPhoto->add($animalPhoto);
            $animalPhoto->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalPhoto(AnimalPhoto $animalPhoto): static
    {
        if ($this->animalPhoto->removeElement($animalPhoto)) {
            // set the owning side to null (unless already changed)
            if ($animalPhoto->getAnimal() === $this) {
                $animalPhoto->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalHistory>
     */
    public function getAnimalHistory(): Collection
    {
        return $this->animalHistory;
    }

    public function addAnimalHistory(AnimalHistory $animalHistory): static
    {
        if (!$this->animalHistory->contains($animalHistory)) {
            $this->animalHistory->add($animalHistory);
            $animalHistory->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalHistory(AnimalHistory $animalHistory): static
    {
        if ($this->animalHistory->removeElement($animalHistory)) {
            // set the owning side to null (unless already changed)
            if ($animalHistory->getAnimal() === $this) {
                $animalHistory->setAnimal(null);
            }
        }

        return $this;
    }

    public function getEnclosure(): ?Enclosure
    {
        return $this->enclosure;
    }

    public function setEnclosure(?Enclosure $enclosure): static
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateUpdatedAt(): void
    {
        $this->updated_at = new \DateTime();
    }
}
