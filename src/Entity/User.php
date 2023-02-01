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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Unique;

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

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Student $student = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?HighSchool $highSchool = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Speaker $speaker = null;

    #[ORM\Column]
    private ?bool $isHashed = false;

    public function __construct()
    {
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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        // unset the owning side of the relation if necessary
        if ($student === null && $this->student !== null) {
            $this->student->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($student !== null && $student->getUser() !== $this) {
            $student->setUser($this);
        }

        $this->student = $student;

        return $this;
    }

    public function getHighSchool(): ?HighSchool
    {
        return $this->highSchool;
    }

    public function setHighSchool(?HighSchool $highSchool): self
    {
        // unset the owning side of the relation if necessary
        if ($highSchool === null && $this->highSchool !== null) {
            $this->highSchool->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($highSchool !== null && $highSchool->getUser() !== $this) {
            $highSchool->setUser($this);
        }

        $this->highSchool = $highSchool;

        return $this;
    }

    public function getSpeaker(): ?Speaker
    {
        return $this->speaker;
    }

    public function setSpeaker(?Speaker $speaker): self
    {
        // unset the owning side of the relation if necessary
        if ($speaker === null && $this->speaker !== null) {
            $this->speaker->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($speaker !== null && $speaker->getUser() !== $this) {
            $speaker->setUser($this);
        }

        $this->speaker = $speaker;

        return $this;
    }

    public function getIsHashed(): ?bool
    {
        return $this->isHashed;
    }

    public function setIsHashed(bool $isHashed): self
    {
        $this->isHashed = $isHashed;

        return $this;
    }
}
