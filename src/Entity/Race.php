<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RaceRepository::class)
 */
class Race
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raceName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaceName(): ?string
    {
        return $this->raceName;
    }

    public function setRaceName(string $raceName): self
    {
        $this->raceName = $raceName;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
