<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\MappedSuperclass]
abstract class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column]
    protected array $roles = [];

    #[ORM\Column]
    protected ?string $password = null;
    
    #[ORM\ManyToMany(targetEntity: Folder::class, inversedBy: 'authorizedUser')]
    protected Collection $allowedFolders;


    public function __construct()
    {
        $this->allowedFolders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAllowedFolder(): Collection
    {
        return $this->allowedFolders;
    }
    public function addAllowedFolder(Folder $folder): self
    {
        if (!$this->allowedFolders->contains($folder)) {
            $this->allowedFolders->add($folder);
            $folder->addAuthorizedUser($this);
        }

        return $this;
    }

    public function removeAllowedFolder(?Folder $folder): self
    {
        if ($this->allowedFolders->removeElement($folder)) {
            if ($folder->getOwner() === $this) {
                $folder->removeAuthorizedUser(null);
            }
        }

        return $this;
    }
}
