<?php

namespace App\Entity;

use App\Repository\LesonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LesonRepository::class)]
class Leson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $lesonCode = null;

    #[ORM\Column(length: 50)]
    private ?string $lesonTitle = null;

    #[ORM\Column]
    private ?int $timeAllocated = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'course')]
    private ?Course $Course = null;

    #[ORM\ManyToOne(inversedBy: 'AdminUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AdminUsers $AdminUsers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLesonCode(): ?string
    {
        return $this->lesonCode;
    }

    public function setLesonCode(string $lesonCode): static
    {
        $this->lesonCode = $lesonCode;

        return $this;
    }

    public function getLesonTitle(): ?string
    {
        return $this->lesonTitle;
    }

    public function setLesonTitle(string $lesonTitle): static
    {
        $this->lesonTitle = $lesonTitle;

        return $this;
    }

    public function getTimeAllocated(): ?int
    {
        return $this->timeAllocated;
    }

    public function setTimeAllocated(int $timeAllocated): static
    {
        $this->timeAllocated = $timeAllocated;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->Course;
    }

    public function setCourse(?Course $Course): static
    {
        $this->Course = $Course;

        return $this;
    }

    public function getAdminUsers(): ?AdminUsers
    {
        return $this->AdminUsers;
    }

    public function setAdminUsers(?AdminUsers $AdminUsers): static
    {
        $this->AdminUsers = $AdminUsers;

        return $this;
    }
}
