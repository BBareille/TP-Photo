<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo extends Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'childrenPhoto')]
    protected ?Folder $parentFolder = null;
    #[ORM\ManyToOne(targetEntity: ColorFolder::class, cascade: ['persist', 'remove'], inversedBy: 'childrenPhoto')]
    private ?ColorFolder $colorFolder = null;

    #[ORM\Column(length: 255)]
    private ?string $source;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'photos',
                cascade: ['persist', 'remove'])]
    private Collection $tags;
    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Comment::class)]
    private Collection $comments;
    #[ORM\Column(name: 'isValid', type: "boolean")]
    private bool $isValid = false;
    #[ORM\Column(name: 'isRejected', type: "boolean")]
    private ?bool $isRejected = false;
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getTags(){
        return $this->tags;
    }

    public function addTag(Tags $tag)
    {
        if(!$this->tags->contains($tag))
        {
            $this->tags->add($tag);
            $tag->addPhoto($this);
        }
    }

    public function removeTag(Tags $tags)
    {
        if($this->tags->contains($tags))
        {
            $this->tags->remove($tags);
            $tags->removePhoto($this);
        }
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentFolder(): ?Folder
    {
        return $this->parentFolder;
    }

    public function setParentFolder(?Folder $parentFolder): self
    {
        $this->parentFolder = $parentFolder;

        return $this;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function isIsRejected(): ?bool
    {
        return $this->isRejected;
    }

    public function setIsRejected(bool $isRejected): self
    {
        $this->isRejected = $isRejected;

        return $this;
    }

    public function getColorFolder(): ?ColorFolder
    {
        return $this->colorFolder;
    }

    public function setColorFolder(?ColorFolder $colorFolder): self
    {
        $this->colorFolder = $colorFolder;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setCreator($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCreator() === $this) {
                $comment->setCreator(null);
            }
        }

        return $this;
    }



}
