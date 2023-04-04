<?php

namespace App\Entity;

use App\Repository\FolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'folder', targetEntity: Photo::class, cascade: ['persist', 'remove'])]
    private Collection $photoCollection;

    #[ORM\ManyToOne(inversedBy: 'folders')]
    private ?User $owner = null;

    #[ORM\ManyToOne(targetEntity: self::class, cascade: ['persist', 'remove'], inversedBy: 'subFolders')]
    private ?self $folder = null;

    #[ORM\OneToMany(mappedBy: 'folder', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private Collection $subFolders;

    public function __construct()
    {
        $this->photoCollection = new ArrayCollection();
        $this->subFolders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotoCollection(): Collection
    {
        return $this->photoCollection;
    }

    public function addPhotoCollection(Photo $photoCollection): self
    {
        if (!$this->photoCollection->contains($photoCollection)) {
            $this->photoCollection->add($photoCollection);
            $photoCollection->setFolder($this);
        }

        return $this;
    }

    public function removePhotoCollection(Photo $photoCollection): self
    {
        if ($this->photoCollection->removeElement($photoCollection)) {
            // set the owning side to null (unless already changed)
            if ($photoCollection->getFolder() === $this) {
                $photoCollection->setFolder(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getFolder(): ?self
    {
        return $this->folder;
    }

    public function setFolder(?self $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubFolders(): Collection
    {
        return $this->subFolders;
    }

    public function addSubFolder(self $subFolder): self
    {
        if (!$this->subFolders->contains($subFolder)) {
            $this->subFolders->add($subFolder);
            $subFolder->setFolder($this);
        }

        return $this;
    }

    public function removeSubFolder(self $subFolder): self
    {
        if ($this->subFolders->removeElement($subFolder)) {
            // set the owning side to null (unless already changed)
            if ($subFolder->getFolder() === $this) {
                $subFolder->setFolder(null);
            }
        }

        return $this;
    }


}
