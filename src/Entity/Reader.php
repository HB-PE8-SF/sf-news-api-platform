<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReaderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: ReaderRepository::class)]
class Reader extends User
{
    #[ORM\ManyToOne(inversedBy: 'readers')]
    #[Groups(['users:read'])]
    private ?Category $favoriteCategory = null;

    public function getFavoriteCategory(): ?Category
    {
        return $this->favoriteCategory;
    }

    public function setFavoriteCategory(?Category $favoriteCategory): static
    {
        $this->favoriteCategory = $favoriteCategory;

        return $this;
    }
}
