<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $StudentCode = null;

    #[ORM\Column(length: 10)]
    private ?string $studentFirstName = null;

    #[ORM\Column(length: 100)]
    private ?string $studentName = null;

    #[ORM\Column(length: 100)]
    private ?string $studentEmail = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $studentPhoto = null;

    #[ORM\Column(length: 100)]
    private ?string $studentPassword = null;

    #[ORM\ManyToOne(inversedBy: 'student')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, StudentCourse>
     */
    #[ORM\OneToMany(targetEntity: StudentCourse::class, mappedBy: 'student', orphanRemoval: true)]
    private Collection $receipt;

    public function __construct()
    {
        $this->receipt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentName(): ?string
    {
        return $this->StudentName;
    }

    public function setStudentName(string $StudentName): static
    {
        $this->StudentName = $StudentName;

        return $this;
    }

    public function getStudentFirstName(): ?string
    {
        return $this->studentFirstName;
    }

    public function setStudentFirstName(string $studentFirstName): static
    {
        $this->studentFirstName = $studentFirstName;

        return $this;
    }

    public function getStudentEmail(): ?string
    {
        return $this->studentEmail;
    }

    public function setStudentEmail(string $studentEmail): static
    {
        $this->studentEmail = $studentEmail;

        return $this;
    }

    public function getStudentPhoto(): ?string
    {
        return $this->studentPhoto;
    }

    public function setStudentPhoto(?string $studentPhoto): static
    {
        $this->studentPhoto = $studentPhoto;

        return $this;
    }

    public function getStudentPassword(): ?string
    {
        return $this->studentPassword;
    }

    public function setStudentPassword(string $studentPassword): static
    {
        $this->studentPassword = $studentPassword;

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

    /**
     * @return Collection<int, StudentCourse>
     */
    public function getReceipt(): Collection
    {
        return $this->receipt;
    }

    public function addReceipt(StudentCourse $receipt): static
    {
        if (!$this->receipt->contains($receipt)) {
            $this->receipt->add($receipt);
            $receipt->setStudent($this);
        }

        return $this;
    }

    public function removeReceipt(StudentCourse $receipt): static
    {
        if ($this->receipt->removeElement($receipt)) {
            // set the owning side to null (unless already changed)
            if ($receipt->getStudent() === $this) {
                $receipt->setStudent(null);
            }
        }

        return $this;
    }
}
