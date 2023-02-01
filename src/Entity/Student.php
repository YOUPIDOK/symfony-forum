<?php

namespace App\Entity;

use App\Enum\HighSchoolDegreeEnum;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table(name: 'students')]
#[UniqueEntity('user')]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[NotNull]
    private ?HighSchool $highSchool = null;

    #[ORM\Column(length: 50)]
    #[NotNull]
    private ?string $degree = HighSchoolDegreeEnum::SECOND;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: SurveyAnswer::class, cascade: ['remove'])]
    private Collection $surveyAnswers;

    #[ORM\OneToOne(inversedBy: 'student', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: WorkshopReservation::class, cascade: ['remove'])]
    private Collection $workshopReservations;

    public function __toString(): string
    {
        return '' . $this->user?->getIdentity();
    }

    public function __construct()
    {
        $this->surveyAnswers = new ArrayCollection();
        $this->workshopReservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDegreeValue()
    {
        return HighSchoolDegreeEnum::getDegree($this->degree);
    }

    public function getHighSchool(): ?HighSchool
    {
        return $this->highSchool;
    }

    public function setHighSchool(?HighSchool $highSchool): self
    {
        $this->highSchool = $highSchool;

        return $this;
    }

    public function getDegree(): ?string
    {
        return $this->degree;
    }

    public function setDegree(?string $degree): self
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * @return Collection<int, SurveyAnswer>
     */
    public function getSurveyAnswers(): Collection
    {
        return $this->surveyAnswers;
    }

    public function addSurveyAnswer(SurveyAnswer $surveyAnswer): self
    {
        if (!$this->surveyAnswers->contains($surveyAnswer)) {
            $this->surveyAnswers->add($surveyAnswer);
            $surveyAnswer->setStudent($this);
        }

        return $this;
    }

    public function removeSurveyAnswer(SurveyAnswer $surveyAnswer): self
    {
        if ($this->surveyAnswers->removeElement($surveyAnswer)) {
            // set the owning side to null (unless already changed)
            if ($surveyAnswer->getStudent() === $this) {
                $surveyAnswer->setStudent(null);
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

    /**
     * @return Collection<int, WorkshopReservation>
     */
    public function getWorkshopReservations(): Collection
    {
        return $this->workshopReservations;
    }

    public function addWorkshopReservation(WorkshopReservation $workshopReservation): self
    {
        if (!$this->workshopReservations->contains($workshopReservation)) {
            $this->workshopReservations->add($workshopReservation);
            $workshopReservation->setStudent($this);
        }

        return $this;
    }

    public function removeWorkshopReservation(WorkshopReservation $workshopReservation): self
    {
        if ($this->workshopReservations->removeElement($workshopReservation)) {
            // set the owning side to null (unless already changed)
            if ($workshopReservation->getStudent() === $this) {
                $workshopReservation->setStudent(null);
            }
        }

        return $this;
    }
}
