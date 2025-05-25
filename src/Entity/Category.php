<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $categoryCode = null;

    #[ORM\Column(length: 30)]
    private ?string $categoryLabel = null;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryCode(): ?string
    {
        return $this->categoryCode;
    }

    public function setCategoryCode(string $categoryCode): static
    {
        $this->categoryCode = $categoryCode;

        return $this;
    }

    public function getCategoryLabel(): ?string
    {
        return $this->categoryLabel;
    }

    public function setCategoryLabel(string $categoryLabel): static
    {
        $this->categoryLabel = $categoryLabel;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Course $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
            $category->setCategory($this);
        }

        return $this;
    }

    public function removeCategory(Course $category): static
    {
        if ($this->category->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCategory() === $this) {
                $category->setCategory(null);
            }
        }

        return $this;
    }
}
