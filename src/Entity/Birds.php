<?php

namespace App\Entity;

use App\Repository\BirdsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BirdsRepository::class)]
class Birds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    private ?string $song = null;

    #[ORM\OneToMany(mappedBy: 'birds', targetEntity: Totaldata::class)]
    private Collection $totaldatas;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'birds')]
    private Collection $users;

    public function __construct()
    {
        $this->totaldatas = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getSong(): ?string
    {
        return $this->song;
    }

    public function setSong(string $song): self
    {
        $this->song = $song;

        return $this;
    }

    /**
     * @return Collection<int, Totaldata>
     */
    public function getTotaldatas(): Collection
    {
        return $this->totaldatas;
    }

    public function addTotaldata(Totaldata $totaldata): self
    {
        if (!$this->totaldatas->contains($totaldata)) {
            $this->totaldatas->add($totaldata);
            $totaldata->setBirds($this);
        }

        return $this;
    }

    public function removeTotaldata(Totaldata $totaldata): self
    {
        if ($this->totaldatas->removeElement($totaldata)) {
            // set the owning side to null (unless already changed)
            if ($totaldata->getBirds() === $this) {
                $totaldata->setBirds(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addBird($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeBird($this);
        }

        return $this;
    }
    
}
