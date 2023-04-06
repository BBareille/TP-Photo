<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo extends Files
{
    #[ORM\Column(length: 255)]
    private ?string $source;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'photos')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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



}
