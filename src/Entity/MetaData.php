<?php

namespace App\Entity;

use App\Repository\MetaDataRepository;
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
    
    #[ORM\OneToOne(inversedBy: 'metaData', targetEntity: Files::class)]
    #[ORM\JoinColumn(name: 'files_id', referencedColumnName: 'id')]
    private Files $files;

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
}
