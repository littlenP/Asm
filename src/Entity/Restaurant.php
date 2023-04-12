<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $restaurantname = null;

    #[ORM\Column(length: 255)]
    private ?string $restaurantimage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionrestaurant = null;

    #[ORM\ManyToMany(targetEntity: Food::class, mappedBy: 'restaurant')]
    private Collection $Food;

    public function __construct()
    {
        $this->Food = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRestaurantname(): ?string
    {
        return $this->restaurantname;
    }

    public function setRestaurantname(string $restaurantname): self
    {
        $this->restaurantname = $restaurantname;

        return $this;
    }

    public function getDescriptionRestaurant(): ?string
    {
        return $this->descriptionrestaurant;
    }
    public function setDescriptionRestaurant(string $descriptionrestaurant ): self
    {
        $this->descriptionrestaurant = $descriptionrestaurant;
        return $this;
    }

    public function getRestaurantimage(): ?string
    {
        return $this->restaurantimage;
    }

    public function setRestaurantimage(string $restaurantimage): self
    {
        $this->restaurantimage = $restaurantimage;

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
            $food->addRestaurant($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->Food->removeElement($food)) {
            $food->removeRestaurant($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getRestaurantname();  // or some string field in your Vegetal Entity
    }
}
