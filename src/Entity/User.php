<?php

namespace App\Entity;

use App\Enum\UserRoleEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email')]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[NotNull]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 80)]
    #[NotNull]
    private ?string $firstname = null;

    #[ORM\Column(length: 80)]
    #[NotNull]
    private ?string $lastname = null;

    #[ORM\Column(length: 13)]
    #[NotNull]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Speaker::class, cascade: ['remove'])]
    private Collection $speakers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Student::class, cascade: ['remove'])]
    private Collection $students;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: HighSchool::class, cascade: ['remove'])]
    private Collection $highSchools;

    public function __construct()
    {
        $this->speakers = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->highSchools = new ArrayCollection();
    }

    public function __toString(): string
    {
        return '' . $this->getIdentity();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRolesValue()
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = UserRoleEnum::getRole($role);
        }

        return implode( ',', $roles);
    }

    public function removeRole(string $role): self
    {
        $roles = [];

        foreach ($this->roles as $r) {
            if ($r !== $role) {
                $roles[] = $r;
            }
        }

        $this->roles = $roles;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);

        return $this;
    }

    public function getIdentity(?bool $addPrefix = false): string
    {
        $toString = $this->firstname !== null ? (ucfirst($this->firstname) . ' ') : '';
        $toString .= $this->lastname !== null ? ucfirst($this->lastname) : '';

        return $toString;
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->roles, true);
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Speaker>
     */
    public function getSpeakers(): Collection
    {
        return $this->speakers;
    }

    public function addSpeaker(Speaker $speaker): self
    {
        if (!$this->speakers->contains($speaker)) {
            $this->speakers->add($speaker);
            $speaker->setUser($this);
        }

        return $this;
    }

    public function removeSpeaker(Speaker $speaker): self
    {
        if ($this->speakers->removeElement($speaker)) {
            // set the owning side to null (unless already changed)
            if ($speaker->getUser() === $this) {
                $speaker->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setUser($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getUser() === $this) {
                $student->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HighSchool>
     */
    public function getHighSchools(): Collection
    {
        return $this->highSchools;
    }

    public function addHighSchool(HighSchool $highSchool): self
    {
        if (!$this->highSchools->contains($highSchool)) {
            $this->highSchools->add($highSchool);
            $highSchool->setUser($this);
        }

        return $this;
    }

    public function removeHighSchool(HighSchool $highSchool): self
    {
        if ($this->highSchools->removeElement($highSchool)) {
            // set the owning side to null (unless already changed)
            if ($highSchool->getUser() === $this) {
                $highSchool->setUser(null);
            }
        }

        return $this;
    }
}
