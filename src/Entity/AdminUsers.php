<?php

namespace App\Entity;

use App\Repository\AdminUsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminUsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class AdminUsers implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $userPhoto = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'AdminUser', orphanRemoval: true)]
    private Collection $student;

    /**
     * @var Collection<int, Course>
     */
    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'adminUsers', orphanRemoval: true)]
    private Collection $AdminUser;

    /**
     * @var Collection<int, Leson>
     */
    #[ORM\OneToMany(targetEntity: Leson::class, mappedBy: 'AdminUsers', orphanRemoval: true)]
    private Collection $AdminUsers;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->AdminUser = new ArrayCollection();
        $this->AdminUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);

    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserPhoto(): ?string
    {
        return $this->userPhoto;
    }

    public function setUserPhoto(?string $userPhoto): static
    {
        $this->userPhoto = $userPhoto;

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
            $student->setAdminUser($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->student->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getAdminUser() === $this) {
                $student->setAdminUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getAdminUser(): Collection
    {
        return $this->AdminUser;
    }

    public function addAdminUser(Course $adminUser): static
    {
        if (!$this->AdminUser->contains($adminUser)) {
            $this->AdminUser->add($adminUser);
            $adminUser->setAdminUsers($this);
        }

        return $this;
    }

    public function removeAdminUser(Course $adminUser): static
    {
        if ($this->AdminUser->removeElement($adminUser)) {
            // set the owning side to null (unless already changed)
            if ($adminUser->getAdminUsers() === $this) {
                $adminUser->setAdminUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Leson>
     */
    public function getAdminUsers(): Collection
    {
        return $this->AdminUsers;
    }
}
