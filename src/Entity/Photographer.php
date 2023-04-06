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
    public function __construct()
    {
        parent::__construct();
        $this->personalFolder = new ArrayCollection();
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

}
