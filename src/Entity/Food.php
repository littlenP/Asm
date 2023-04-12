<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Chef::class, inversedBy: 'Food')]
    private Collection $chef;

    #[ORM\ManyToMany(targetEntity: Restaurant::class, inversedBy: 'Food')]
    private Collection $restaurant;

    #[ORM\ManyToMany(targetEntity: Comment::class, mappedBy: 'food')]
    private Collection $Comments;

    public function __construct()
    {
        $this->chef = new ArrayCollection();
        $this->restaurant = new ArrayCollection();
        $this->Comments = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Chef>
     */
    public function getChef(): Collection
    {
        return $this->chef;
    }

    public function addChef(Chef $chef): self
    {
        if (!$this->chef->contains($chef)) {
            $this->chef->add($chef);
        }

        return $this;
    }

    public function removeChef(Chef $chef): self
    {
        $this->chef->removeElement($chef);

        return $this;
    }

    /**
     * @return Collection<int, Restaurant>
     */
    public function getRestaurant(): Collection
    {
        return $this->restaurant;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurant->contains($restaurant)) {
            $this->restaurant->add($restaurant);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        $this->restaurant->removeElement($restaurant);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->Comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->Comments->contains($comment)) {
            $this->Comments->add($comment);
            $comment->addFood($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->Comments->removeElement($comment)) {
            $comment->removeFood($this);
        }

        return $this;
    }

}
