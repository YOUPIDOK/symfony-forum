<?php

namespace App\Entity;

use App\Repository\HighSchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: HighSchoolRepository::class)]
#[ORM\Table(name: 'high_schools')]
#[UniqueEntity('name')]
class HighSchool
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'highSchool', targetEntity: Student::class, cascade: ['remove'])]
    private Collection $students;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'highSchools')]
    private ?User $user = null;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function __toString(): string
    {
        return '' . $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
            $student->setHighSchool($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getHighSchool() === $this) {
                $student->setHighSchool(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
