<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Photographer::class, inversedBy: 'personalFolder')]
    protected ?Photographer $owner = null;

    #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'childrenFolder')]
    protected ?Folder $parentFolder = null;

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
}