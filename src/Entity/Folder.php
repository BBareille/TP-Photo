<?php

namespace App\Entity;

use App\Repository\FolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder extends Files
{
    #[ORM\OneToMany(mappedBy: 'parentFolder', targetEntity: Folder::class ,cascade: ['persist', 'remove'] )]
    private ?Collection $childrenFolder;
    #[ORM\OneToMany(mappedBy: 'parentFolder', targetEntity: Photo::class)]
    private ?Collection $childrenPhoto;
    #[ORM\ManyToMany(targetEntity: Client::class, mappedBy: 'allowedFolders')]
    private Collection $authorizedUser;
    public function __construct()
    {
        $this->childrenPhoto = new ArrayCollection();
        $this->childrenFolder = new ArrayCollection();
        $this->authorizedUser = new ArrayCollection();
    }


    /**
     * @return Collection|null
     */
    public function getChildrenPhoto(): ?Collection
    {
        return $this->childrenPhoto;
    }

    /**
     * @return Collection
     */
    public function getChildrenFolder(): Collection
    {
        return $this->childrenFolder;
    }

    /**
     * @return Collection
     */
    public function getAuthorizedUser(): Collection
    {
        return $this->authorizedUser;
    }

    public function addChildrenFolder(Files $files)
    {
        if(!$this->childrenFolder->contains($files))
        {
            $this->childrenFolder->add($files);
            $files->setParentFolder($this);
        }

    }
    public function addChildrenPhoto(Files $files)
    {
        if(!$this->childrenPhoto->contains($files))
        {
            $this->childrenPhoto->add($files);
            $files->setParentFolder($this);
        }

    }

    public function addAuthorizedUser(User $user)
    {
        if(!$this->authorizedUser->contains($user))
        {
            $this->authorizedUser->add($user);
            $user->addAllowedFolder($this);
        }
    }

    public function removeAuthorizedUser(?User $user)
    {
        if($this->authorizedUser->contains($user))
        {
            $this->authorizedUser->remove($user);
            $user->removeAllowedFolder(null);
        }
    }

}