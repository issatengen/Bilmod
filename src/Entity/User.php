<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $userCode = null;

    #[ORM\Column(length: 100)]
    private ?string $userFirstName = null;

    #[ORM\Column(length: 100)]
    private ?string $userName = null;

    #[ORM\Column(length: 100)]
    private ?string $userEmail = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $userphoto = null;

    #[ORM\Column(length: 100)]
    private ?string $userPassword = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $student;

    /**
     * @var Collection<int, Leson>
     */
    #[ORM\OneToMany(targetEntity: Leson::class, mappedBy: 'user')]
    private Collection $user;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCode(): ?string
    {
        return $this->userCode;
    }

    public function setUserCode(string $userCode): static
    {
        $this->userCode = $userCode;

        return $this;
    }

    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    public function setUserFirstName(string $userFirstName): static
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): static
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserphoto(): ?string
    {
        return $this->userphoto;
    }

    public function setUserphoto(?string $userphoto): static
    {
        $this->userphoto = $userphoto;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(string $userPassword): static
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->student->contains($student)) {
            $this->student->add($student);
            $student->setUser($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->student->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getUser() === $this) {
                $student->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Leson>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Leson $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setUser($this);
        }

        return $this;
    }

    public function removeUser(Leson $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUser() === $this) {
                $user->setUser(null);
            }
        }

        return $this;
    }
}
