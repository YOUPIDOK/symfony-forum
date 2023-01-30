<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: SurveyRepository::class)]
#[ORM\Table(name: 'surveys')]
#[UniqueEntity('name')]
class Survey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'surveys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Forum $forum = null;

    #[ORM\OneToMany(mappedBy: 'survey', targetEntity: SurveyQuestion::class, cascade: ['remove'])]
    private Collection $surveyQuestions;

    public function __construct()
    {
        $this->surveyQuestions = new ArrayCollection();
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

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * @return Collection<int, SurveyQuestion>
     */
    public function getSurveyQuestions(): Collection
    {
        return $this->surveyQuestions;
    }

    public function addSurveyQuestion(SurveyQuestion $surveyQuestion): self
    {
        if (!$this->surveyQuestions->contains($surveyQuestion)) {
            $this->surveyQuestions->add($surveyQuestion);
            $surveyQuestion->setSurvey($this);
        }

        return $this;
    }

    public function removeSurveyQuestion(SurveyQuestion $surveyQuestion): self
    {
        if ($this->surveyQuestions->removeElement($surveyQuestion)) {
            // set the owning side to null (unless already changed)
            if ($surveyQuestion->getSurvey() === $this) {
                $surveyQuestion->setSurvey(null);
            }
        }

        return $this;
    }
}
