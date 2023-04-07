<?php

namespace App\Entity;

use App\Repository\MetaDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetaDataRepository::class)]
class MetaData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;
    
    #[ORM\ManyToOne(targetEntity: Photographer::class, inversedBy: 'metaDataList')]
    private Photographer $photographer;

    #[ORM\ManyToMany(targetEntity: Files::class, inversedBy: 'metaData')]
    private Collection $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }
    /**
     * @return Photographer
     */
    public function getPhotographer(): Photographer
    {
            return $this->photographer;
    }
    
    /**
     * @param Photographer $photographer
     */
    public function setPhotographer(Photographer $photographer): void
    {
            $this->photographer = $photographer;
    }
    
    /**
     * @return Files
     */
    public function getFiles(): Files
    {
            return $this->files;
    }
    
    /**
     * @param Files $files
     */
    public function setFiles(Files $files): void
    {
            $this->files = $files;
    }
    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function addFile(Files $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
        }

        return $this;
    }

    public function removeFile(Files $file): self
    {
        $this->files->removeElement($file);

        return $this;
    }
}