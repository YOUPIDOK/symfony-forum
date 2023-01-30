<?php

namespace App\Entity;

use App\Repository\SurveyAnswerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SurveyAnswerRepository::class)]
#[ORM\Table(name: 'survey_answers')]
#[UniqueEntity(fields: ['student', 'surveyQuestion'])]
class SurveyAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $answer = null;

    #[ORM\ManyToOne(inversedBy: 'surveyAnswers')]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'surveyAnswers')]
    private ?SurveyQuestion $surveyQuestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSurveyQuestion(): ?SurveyQuestion
    {
        return $this->surveyQuestion;
    }

    public function setSurveyQuestion(?SurveyQuestion $surveyQuestion): self
    {
        $this->surveyQuestion = $surveyQuestion;

        return $this;
    }
}
