<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptioncomment = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'Comments')]
    private Collection $user;

    #[ORM\ManyToMany(targetEntity: Food::class, inversedBy: 'Comments')]
    private Collection $food;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->food = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionComment(): ?string
    {
        return $this->descriptioncomment;
    }

    public function setDescriptionComment(string $descriptioncomment): self
    {
        $this->descriptioncomment = $descriptioncomment;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Food>
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): self
    {
        if (!$this->food->contains($food)) {
            $this->food->add($food);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        $this->food->removeElement($food);

        return $this;
    }
}
