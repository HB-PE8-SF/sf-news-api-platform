<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReaderRepository::class)]
class Reader extends User
{
    #[ORM\ManyToOne(inversedBy: 'readers')]
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
