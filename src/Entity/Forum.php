<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
#[ORM\Table(name: 'forums')]
#[UniqueEntity('name')]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'forum', targetEntity: Workshop::class, cascade: ['remove'])]
    private Collection $workshops;

    #[ORM\Column]
    private ?DateTime $startAt = null;

    #[ORM\Column]
    private ?DateTime $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'forums')]
    #[NotNull]
    private ?Survey $survey = null;

    public function __construct()
    {
        $this->workshops = new ArrayCollection();
    }

    public function canAddReservation()
    {
        return $this->endAt > new DateTime('now');
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
     * @return Collection<int, Workshop>
     */
    public function getWorkshops(): Collection
    {
        return $this->workshops;
    }

    public function addWorkshop(Workshop $workshop): self
    {
        if (!$this->workshops->contains($workshop)) {
            $this->workshops->add($workshop);
            $workshop->setForum($this);
        }

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        if ($this->workshops->removeElement($workshop)) {
            // set the owning side to null (unless already changed)
            if ($workshop->getForum() === $this) {
                $workshop->setForum(null);
            }
        }

        return $this;
    }

    public function getStartAt(): ?DateTime
    {
        return $this->startAt;
    }

    public function setStartAt(DateTime $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?DateTime
    {
        return $this->endAt;
    }

    public function setEndAt(DateTime $endAt): self
    {
        $this->endAt = $endAt;

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
}
