<?php

namespace App\Entity;

use App\Enum\SurveyQuestionTypeEnum;
use App\Repository\SurveyQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SurveyQuestionRepository::class)]
#[ORM\Table(name: 'survey_questions')]
#[UniqueEntity('name')]
class SurveyQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 50)]
    private ?string $type = SurveyQuestionTypeEnum::OPEN;

    #[ORM\ManyToOne(inversedBy: 'surveyQuestions')]
    #[ORM\Column(nullable: true)]
    private ?Survey $survey = null;

    #[ORM\OneToMany(mappedBy: 'surveyQuestion', targetEntity: SurveyAnswer::class, cascade: ['remove'])]
    private Collection $surveyAnswers;

    public function __construct()
    {
        $this->surveyAnswers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return '' . $this->question;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

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
            $surveyAnswer->setSurveyQuestion($this);
        }

        return $this;
    }

    public function removeSurveyAnswer(SurveyAnswer $surveyAnswer): self
    {
        if ($this->surveyAnswers->removeElement($surveyAnswer)) {
            // set the owning side to null (unless already changed)
            if ($surveyAnswer->getSurveyQuestion() === $this) {
                $surveyAnswer->setSurveyQuestion(null);
            }
        }

        return $this;
    }
}
