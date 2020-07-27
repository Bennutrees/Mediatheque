<?php

namespace App\Entity;

use App\Repository\CdRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CdRepository::class)
 */
class Cd extends Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $plages;

    /**
     * @ORM\Column(type="time")
     */
    private ?DateTimeInterface $duration;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlages(): ?int
    {
        return $this->plages;
    }

    public function setPlages(int $plages): self
    {
        $this->plages = $plages;

        return $this;
    }

    public function getDuration(): ?DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
