<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
#[ORM\Table(name: 'workshops')]
#[UniqueEntity('name')]
class Workshop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $name = null;

    #[ORM\Column]
    private ?DateTime $startAt = null;

    #[ORM\Column]
    private ?DateTime $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'workshops')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WorkshopSector $sector = null;

    #[ORM\ManyToOne(inversedBy: 'workshops')]
    private ?Forum $forum = null;

    #[ORM\ManyToMany(targetEntity: Speaker::class, inversedBy: 'workshops')]
    #[ORM\JoinTable(name: 'workshop_as_speaker')]
    #[Count(min: 1, minMessage: 'Minimum 1')]
    private Collection $speakers;

    #[ORM\ManyToMany(targetEntity: Resource::class, inversedBy: 'workshops')]
    #[ORM\JoinTable(name: 'workshop_as_resource')]
    private Collection $resources;

    #[ORM\ManyToOne(inversedBy: 'workshops')]
    #[ORM\JoinColumn(nullable: true)]

    private ?Room $room = null;

    #[ORM\ManyToMany(targetEntity: Job::class, inversedBy: 'workshops')]
    #[Count(min: 1, minMessage: 'Minimum 1')]
    #[ORM\JoinTable(name: 'workshop_as_job')]
    private Collection $jobs;

    public function __construct()
    {
        $this->speakers = new ArrayCollection();
        $this->resources = new ArrayCollection();
        $this->jobs = new ArrayCollection();
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

    public function getSector(): ?WorkshopSector
    {
        return $this->sector;
    }

    public function setSector(?WorkshopSector $sector): self
    {
        $this->sector = $sector;

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
        }

        return $this;
    }

    public function removeSpeaker(Speaker $speaker): self
    {
        $this->speakers->removeElement($speaker);

        return $this;
    }

    /**
     * @return Collection<int, Resource>
     */
    public function getResources(): Collection
    {
        return $this->resources;
    }

    public function addResource(Resource $resource): self
    {
        if (!$this->resources->contains($resource)) {
            $this->resources->add($resource);
        }

        return $this;
    }

    public function removeResource(Resource $resource): self
    {
        $this->resources->removeElement($resource);

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        $this->jobs->removeElement($job);

        return $this;
    }
}
