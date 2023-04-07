<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'disc', type: 'string')]
#[ORM\DiscriminatorMap(['folder' => Folder::class, 'photo' =>
            Photo::class, 'colorFolder' => ColorFolder::class])]
abstract class Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;
    
    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'personalFolder')]
    protected ?User $owner = null;

    #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'childrenFolder')]
    protected ?Folder $parentFolder = null;
    
    #[ORM\ManyToMany(targetEntity: MetaData::class, mappedBy: 'files')]
    protected Collection $metaData;

    public function __construct()
    {
        $this->metaData = new ArrayCollection();
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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $user)
    {
        $this->owner = $user;
        return $this;
    }

    public function getParentFolder(): ?Folder
    {
        return $this->parentFolder;
    }

    public function setParentFolder(Folder $folder): self
    {
        $this->parentFolder = $folder;
        return $this;
    }
    
    public function getMetaData(): MetaData{
            return $this->metaData;
    }

    public function setMetaData(?MetaData $metaData): self
    {
        // unset the owning side of the relation if necessary
        if ($metaData === null && $this->metaData !== null) {
            $this->metaData->setFiles(null);
        }

        // set the owning side of the relation if necessary
        if ($metaData !== null && $metaData->getFiles() !== $this) {
            $metaData->setFiles($this);
        }

        $this->metaData = $metaData;

        return $this;
    }

    public function addMetaData(MetaData $metaData): self
    {
        if (!$this->metaData->contains($metaData)) {
            $this->metaData->add($metaData);
            $metaData->addFile($this);
        }

        return $this;
    }

    public function removeMetaData(MetaData $metaData): self
    {
        if ($this->metaData->removeElement($metaData)) {
            $metaData->removeFile($this);
        }

        return $this;
    }
}