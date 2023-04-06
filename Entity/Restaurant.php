<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_restaurant = null;

    #[ORM\Column(length: 255)]
    private ?string $restaurantimage = null;

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
}
