<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ORM\Table(name: 'jobs')]
#[UniqueEntity('name')]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: JobSkill::class, inversedBy: 'jobs')]
    #[ORM\JoinTable(name: 'job_as_job_skill')]
    #[Count(min: 1, minMessage: 'Minimum 1.')]
    private Collection $jobSkills;

    #[ORM\ManyToMany(targetEntity: JobActivity::class, inversedBy: 'jobs')]
    #[ORM\JoinTable(name: 'job_as_job_activity')]
    #[Count(min: 1, minMessage: 'Minimum 1.')]
    private Collection $jobActivities;

    #[ORM\ManyToMany(targetEntity: Workshop::class, mappedBy: 'jobs')]
    private Collection $workshops;

    public function __construct()
    {
        $this->jobSkills = new ArrayCollection();
        $this->jobActivities = new ArrayCollection();
        $this->workshops = new ArrayCollection();
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
     * @return Collection<int, JobSkill>
     */
    public function getJobSkills(): Collection
    {
        return $this->jobSkills;
    }

    public function addJobSkill(JobSkill $jobSkill): self
    {
        if (!$this->jobSkills->contains($jobSkill)) {
            $this->jobSkills->add($jobSkill);
        }

        return $this;
    }

    public function removeJobSkill(JobSkill $jobSkill): self
    {
        $this->jobSkills->removeElement($jobSkill);

        return $this;
    }

    /**
     * @return Collection<int, JobActivity>
     */
    public function getJobActivities(): Collection
    {
        return $this->jobActivities;
    }

    public function addJobActivity(JobActivity $jobActivity): self
    {
        if (!$this->jobActivities->contains($jobActivity)) {
            $this->jobActivities->add($jobActivity);
        }

        return $this;
    }

    public function removeJobActivity(JobActivity $jobActivity): self
    {
        $this->jobActivities->removeElement($jobActivity);

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
            $workshop->addJob($this);
        }

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        if ($this->workshops->removeElement($workshop)) {
            $workshop->removeJob($this);
        }

        return $this;
    }
}
