<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['articles:read', 'users:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['articles:read', 'users:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\OneToMany(targetEntity: Article::class, mappedBy: 'category', orphanRemoval: true)]
    #[Groups(['users:read'])]
    private Collection $articles;

    /**
     * @var Collection<int, Reader>
     */
    #[ORM\OneToMany(targetEntity: Reader::class, mappedBy: 'favoriteCategory')]
    private Collection $readers;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->readers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reader>
     */
    public function getReaders(): Collection
    {
        return $this->readers;
    }

    public function addReader(Reader $reader): static
    {
        if (!$this->readers->contains($reader)) {
            $this->readers->add($reader);
            $reader->setFavoriteCategory($this);
        }

        return $this;
    }

    public function removeReader(Reader $reader): static
    {
        if ($this->readers->removeElement($reader)) {
            // set the owning side to null (unless already changed)
            if ($reader->getFavoriteCategory() === $this) {
                $reader->setFavoriteCategory(null);
            }
        }

        return $this;
    }
}
