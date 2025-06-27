<?php

namespace App\Entity;

use App\Repository\LesonModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LesonModuleRepository::class)]
class LesonModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'module')]
    private ?Item $leson = null;

    /**
     * @var Collection<int, SubModule>
     */
    #[ORM\OneToMany(targetEntity: SubModule::class, mappedBy: 'module')]
    private Collection $subModules;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    public function __construct()
    {
        $this->subModules = new ArrayCollection();
    }

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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLeson(): ?Item
    {
        return $this->leson;
    }

    public function setLeson(?Item $leson): static
    {
        $this->leson = $leson;

        return $this;
    }

    /**
     * @return Collection<int, SubModule>
     */
    public function getSubModules(): Collection
    {
        return $this->subModules;
    }

    public function addSubModule(SubModule $subModule): static
    {
        if (!$this->subModules->contains($subModule)) {
            $this->subModules->add($subModule);
            $subModule->setModule($this);
        }

        return $this;
    }

    public function removeSubModule(SubModule $subModule): static
    {
        if ($this->subModules->removeElement($subModule)) {
            // set the owning side to null (unless already changed)
            if ($subModule->getModule() === $this) {
                $subModule->setModule(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
