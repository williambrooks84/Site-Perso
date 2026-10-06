<?php

namespace App\Entity;

use App\Repository\DesignRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DesignRepository::class)]
#[ApiResource(operations: [
    new GetCollection(),
    new Get(),
    new Post(security: "is_granted('ROLE_ADMIN')"),
])]
class Design
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $previewPath = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getPreviewPath(): ?string
    {
        return $this->previewPath;
    }

    public function setPreviewPath(?string $previewPath): static
    {
        $this->previewPath = $previewPath;

        return $this;
    }
}
