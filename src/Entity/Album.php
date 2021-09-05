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
    private $logoUrl;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity=AlbumComment::class, mappedBy="album", cascade={"remove", "persist"})
     */
    private $albumComments;

    public function __construct()
    {
        $this->albumComments = new ArrayCollection();
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
        return $this->logoUrl;
    }

    public function setLogoUrl(string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;

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
}
