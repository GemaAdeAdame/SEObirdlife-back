<?php

namespace App\Entity;

use App\Repository\TotaldataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TotaldataRepository::class)]
class Totaldata
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'totaldatas')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'totaldatas')]
    private ?Birds $birds = null;

    #[ORM\ManyToOne(inversedBy: 'totaldatas')]
    private ?Plant $plant = null;

    #[ORM\ManyToOne(inversedBy: 'totaldatas')]
    private ?Insect $insect = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBirds(): ?Birds
    {
        return $this->birds;
    }

    public function setBirds(?Birds $birds): self
    {
        $this->birds = $birds;

        return $this;
    }

    public function getPlant(): ?Plant
    {
        return $this->plant;
    }

    public function setPlant(?Plant $plant): self
    {
        $this->plant = $plant;

        return $this;
    }

    public function getInsect(): ?Insect
    {
        return $this->insect;
    }

    public function setInsect(?Insect $insect): self
    {
        $this->insect = $insect;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
