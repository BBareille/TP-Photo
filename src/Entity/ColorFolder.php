<?php

namespace App\Entity;

use App\Repository\ColorFolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorFolderRepository::class)]
class ColorFolder extends Files
{
    #[ORM\Column(length: 15)]
    private ?string $color = null;

    #[ORM\Column(length: 20)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'personalFolder')]
    protected ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'colorFolder', targetEntity: Photo::class)]
    private ?Collection $childrenPhoto;
    public function __construct()
    {
        parent::__construct();
        $this->childrenPhoto = new ArrayCollection();
        $this->metaData = new ArrayCollection();
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection<int, Photo>
     */
    public function getChildrenPhoto(): Collection
    {
        return $this->childrenPhoto;
    }

    public function addChildrenPhoto(Photo $childrenPhoto): self
    {
        if (!$this->childrenPhoto->contains($childrenPhoto)) {
            $this->childrenPhoto->add($childrenPhoto);
            $childrenPhoto->set($this);
        }

        return $this;
    }

    public function removeChildrenPhoto(Photo $childrenPhoto): self
    {
        if ($this->childrenPhoto->removeElement($childrenPhoto)) {
            // set the owning side to null (unless already changed)
            if ($childrenPhoto->get() === $this) {
                $childrenPhoto->set(null);
            }
        }

        return $this;
    }
}
