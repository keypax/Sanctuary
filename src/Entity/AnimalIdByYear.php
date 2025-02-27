<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AnimalIdByYearRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalIdByYearRepository::class)]
class AnimalIdByYear
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $last_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getLastId(): ?int
    {
        return $this->last_id;
    }

    public function setLastId(int $last_id): static
    {
        $this->last_id = $last_id;

        return $this;
    }
}
