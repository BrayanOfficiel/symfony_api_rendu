<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN') or is_granted('ROLE_DIRECTOR')"),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ASSISTANT') or is_granted('ROLE_VETERINARIAN') or is_granted('ROLE_DIRECTOR')"),
        new Delete(security: "is_granted('ROLE_DIRECTOR')")
    ]
)]
#[ORM\Entity]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['read', 'write'])]
    private ?string $path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }
}
