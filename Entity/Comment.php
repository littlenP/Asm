<?php

namespace App\Entity;

use App\Repository\CommentRepository;
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
}
