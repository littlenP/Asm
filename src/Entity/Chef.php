<?php

namespace App\Entity;

use App\Repository\ChefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChefRepository::class)]
class Chef
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $chefname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionchef = null;

    #[ORM\Column(length: 255)]
    private ?string $chefimage = null;

    #[ORM\ManyToMany(targetEntity: Food::class, mappedBy: 'chef')]
    private Collection $Food;

    public function __construct()
    {
        $this->Food = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChefname(): ?string
    {
        return $this->chefname;
    }

    public function setChefname(string $chefname): self
    {
        $this->chefname = $chefname;

        return $this;
    }

    public function getDescriptionChef(): ?string
    {
        return $this->descriptionchef;
    }

    public function setDescriptionChef(string $descriptionchef): self
    {
        $this->descriptionchef = $descriptionchef;
        return $this;
    }
    public function getChefimage(): ?string
    {
        return $this->chefimage;
    }
    public function setChefimage(string $chefimage): self
    {
        $this->chefimage = $chefimage;

        return $this;
    }

    /**
     * @return Collection<int, Food>
     */
    public function getFood(): Collection
    {
        return $this->Food;
    }

    public function addFood(Food $food): self
    {
        if (!$this->Food->contains($food)) {
            $this->Food->add($food);
            $food->addChef($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->Food->removeElement($food)) {
            $food->removeChef($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getChefname();  // or some string field in your Vegetal Entity
    }
}
