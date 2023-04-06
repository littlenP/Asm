<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $foodname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptionfood = null;

    #[ORM\Column(length: 255)]
    private ?string $foodimage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoodname(): ?string
    {
        return $this->foodname;
    }

    public function setFoodname(string $foodname): self
    {
        $this->foodname = $foodname;

        return $this;
    }

    public function getDescriptionFood(): ?string
    {
        return $this->descriptionfood;
    }

    public function setDescriptionFood(string $descriptionfood): self
    {
        $this->descriptionfood = $descriptionfood;

        return $this;
    }

    public function getFoodimage(): ?string
    {
        return $this->foodimage;
    }

    public function setFoodimage(string $foodimage): self
    {
        $this->foodimage = $foodimage;

        return $this;
    }
}
