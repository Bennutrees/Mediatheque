<?php

namespace App\Entity;

use App\Repository\RoleRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

/**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }



    





}
