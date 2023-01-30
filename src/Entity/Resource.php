<?php

namespace App\Entity;

use App\Repository\ResourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
#[ORM\Table(name: 'resources')]
class Resource
{
    const URL = 'URL';
    const FILE = 'FILE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $url = null;

    #[ORM\ManyToMany(targetEntity: Workshop::class, mappedBy: 'resources')]
    private Collection $workshops;

    public function __construct()
    {
        $this->workshops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isUrl(): bool
    {
        return $this->type === self::URL;
    }

    public function isFile(): bool
    {
        return $this->type === self::FILE;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

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
            $workshop->addResource($this);
        }

        return $this;
    }

    public function removeWorkshop(Workshop $workshop): self
    {
        if ($this->workshops->removeElement($workshop)) {
            $workshop->removeResource($this);
        }

        return $this;
    }
}
