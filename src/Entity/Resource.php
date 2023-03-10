<?php

namespace App\Entity;

use App\Enum\ResourceTypeEnum;
use App\Repository\ResourceRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ResourceRepository::class)]
#[ORM\Table(name: 'resources')]
#[UniqueEntity(fields: ['name', 'type'])]
#[Vich\Uploadable]
class Resource
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[NotNull]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $url = null;

    #[ORM\ManyToMany(targetEntity: Workshop::class, mappedBy: 'resources')]
    private Collection $workshops;

    #[ORM\Column(length: 255)]
    #[NotNull]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $filename = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $originalName = null;

    #[Vich\UploadableField(mapping: 'resource_file', fileNameProperty: 'filename', originalName: 'originalName')]
    private ?File $file = null;

    public function __construct()
    {
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

    public function isUrl(): bool
    {
        return $this->type === ResourceTypeEnum::URL;
    }

    public function isFile(): bool
    {
        return $this->type === ResourceTypeEnum::FILE;
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

    public function getTypeValue()
    {
        return ResourceTypeEnum::getType($this->type);
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): self
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function setFile(?File $file = null): self
    {
        $this->file = $file;

        if (null !== $file) {
            $this->setUpdatedAt(new DateTime());
        }

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

}
