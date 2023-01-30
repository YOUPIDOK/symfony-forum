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
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?HighSchool $highSchool = null;

    #[ORM\Column(length: 50)]
    #[NotNull]
    private ?string $degree = HighSchoolDegreeEnum::SECOND;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: SurveyAnswer::class, cascade: ['remove'])]
    private Collection $surveyAnswers;

    public function __construct()
    {
        $this->surveyAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
