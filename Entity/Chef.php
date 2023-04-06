<?php

namespace App\Entity;

use App\Repository\ChefRepository;
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

    public function setDesciptionchef(string $descriptionchef): self
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
}
