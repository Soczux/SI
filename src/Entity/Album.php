<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo_url;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity=AlbumComment::class, mappedBy="album")
     */
    private $albumComments;

    /**
     * @ORM\OneToMany(targetEntity=AlbumReaction::class, mappedBy="album")
     */
    private $albumReactions;

    public function __construct()
    {
        $this->albumComments = new ArrayCollection();
        $this->albumReactions = new ArrayCollection();
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

    public function getLogoUrl(): ?string
    {
        return $this->logo_url;
    }

    public function setLogoUrl(string $logo_url): self
    {
        $this->logo_url = $logo_url;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return Collection|AlbumComment[]
     */
    public function getAlbumComments(): Collection
    {
        return $this->albumComments;
    }

    public function addAlbumComment(AlbumComment $albumComment): self
    {
        if (!$this->albumComments->contains($albumComment)) {
            $this->albumComments[] = $albumComment;
            $albumComment->setAlbum($this);
        }

        return $this;
    }

    public function removeAlbumComment(AlbumComment $albumComment): self
    {
        if ($this->albumComments->removeElement($albumComment)) {
            // set the owning side to null (unless already changed)
            if ($albumComment->getAlbum() === $this) {
                $albumComment->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AlbumReaction[]
     */
    public function getAlbumReactions(): Collection
    {
        return $this->albumReactions;
    }

    public function addAlbumReaction(AlbumReaction $albumReaction): self
    {
        if (!$this->albumReactions->contains($albumReaction)) {
            $this->albumReactions[] = $albumReaction;
            $albumReaction->setAlbum($this);
        }

        return $this;
    }

    public function removeAlbumReaction(AlbumReaction $albumReaction): self
    {
        if ($this->albumReactions->removeElement($albumReaction)) {
            // set the owning side to null (unless already changed)
            if ($albumReaction->getAlbum() === $this) {
                $albumReaction->setAlbum(null);
            }
        }

        return $this;
    }
}
