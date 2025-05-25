<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $courseCode = null;

    #[ORM\Column(length: 50)]
    private ?string $courseTitle = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'category')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, Leson>
     */
    #[ORM\OneToMany(targetEntity: Leson::class, mappedBy: 'Course')]
    private Collection $course;

    public function __construct()
    {
        $this->course = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourseCode(): ?string
    {
        return $this->courseCode;
    }

    public function setCourseCode(string $courseCode): static
    {
        $this->courseCode = $courseCode;

        return $this;
    }

    public function getCourseTitle(): ?string
    {
        return $this->courseTitle;
    }

    public function setCourseTitle(string $courseTitle): static
    {
        $this->courseTitle = $courseTitle;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Leson>
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(Leson $course): static
    {
        if (!$this->course->contains($course)) {
            $this->course->add($course);
            $course->setCourse($this);
        }

        return $this;
    }

    public function removeCourse(Leson $course): static
    {
        if ($this->course->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getCourse() === $this) {
                $course->setCourse(null);
            }
        }

        return $this;
    }
}
