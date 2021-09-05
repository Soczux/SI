<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 */
class Song
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity=SongComment::class, mappedBy="song", cascade={"persist"})
     */
    private $songComments;

    public function __construct()
    {
        $this->songComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
     * @return Collection|SongComment[]
     */
    public function getSongComments(): Collection
    {
        return $this->songComments;
    }

    public function addSongComment(SongComment $songComment): self
    {
        if (!$this->songComments->contains($songComment)) {
            $this->songComments[] = $songComment;
            $songComment->setSong($this);
        }

        return $this;
    }

    public function removeSongComment(SongComment $songComment): self
    {
        if ($this->songComments->removeElement($songComment)) {
            // set the owning side to null (unless already changed)
            if ($songComment->getSong() === $this) {
                $songComment->setSong(null);
            }
        }

        return $this;
    }
}
