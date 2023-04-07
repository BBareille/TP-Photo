<?php
namespace App\Entity;

    use App\Repository\PhotographerRepository;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotographerRepository::class)]
class Photographer extends User

{    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Folder::class, cascade: ['persist', 'remove'])]
    private ?Collection $personalFolder;
    
    #[ORM\OneToMany(mappedBy: 'photographer', targetEntity: MetaData::class,
                cascade: ['persist', 'remove'])]
    private Collection $metaDataList;
    public function __construct()
    {
        parent::__construct();
        $this->personalFolder = new ArrayCollection();
        $this->metaDataList = new ArrayCollection();
        $this->allowedFolders = new ArrayCollection();
    }

    public function getPersonalFolder(): Collection
    {
        return $this->personalFolder;
    }

    public function addPersonalFolder(Folder $folder)
    {
        if (!$this->personalFolder->contains($folder)) {
            $this->personalFolder->add($folder);
            $this->addAllowedFolder($folder);
            $folder->setOwner($this);
        }
    }

    public function removePersonalFolder(Folder $folder)
    {
        if ($this->personalFolder->contains($folder)) {
            $this->personalFolder->remove($folder);
            $this->addAllowedFolder($folder);
            $folder->setOwner(null);
        }
    }

    public function addUserToMyPersonalFolder(Client $user, Folder $folder)
    {
        if ($this->personalFolder->contains($folder)) {
            $user->addAllowedFolder($folder);
        }
    }

    public function removeUserToMyPersonalFolder(User $user, Folder $folder)
    {
        if ($this->personalFolder->contains($folder)) {
            $user->removeAllowedFolder($folder);
        } else if (!$this->personalFolder->contains($folder)) {
            throw new \Exception('Vous n\'êtes pas autorisé à retirer un utilisateur sur ce dossier');
        } else {
            throw new \Exception('Utilisateur inconnu');
        }
    }
    
    public function getMetaDataList(): Collection{
            return $this->metaDataList;
    }

    public function addMetaDataList(MetaData $metaDataList): self
    {
        if (!$this->metaDataList->contains($metaDataList)) {
            $this->metaDataList->add($metaDataList);
            $metaDataList->setPhotographer($this);
        }

        return $this;
    }

    public function removeMetaDataList(MetaData $metaDataList): self
    {
        if ($this->metaDataList->removeElement($metaDataList)) {
            // set the owning side to null (unless already changed)
            if ($metaDataList->getPhotographer() === $this) {
                $metaDataList->setPhotographer(null);
            }
        }

        return $this;
    }
}
