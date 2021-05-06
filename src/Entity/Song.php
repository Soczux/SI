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
     * @ORM\ManyToMany(targetEntity=Playlist::class, mappedBy="song")
     */
    private $playlists;

    /**
     * @ORM\OneToMany(targetEntity=SongComment::class, mappedBy="song")
     */
    private $songComments;

    /**
     * @ORM\OneToMany(targetEntity=SongReaction::class, mappedBy="song")
     */
    private $songReactions;

    public function __construct()
    {
        $this->playlists = new ArrayCollection();
        $this->songComments = new ArrayCollection();
        $this->songReactions = new ArrayCollection();
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
     * @return Collection|Playlist[]
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): self
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists[] = $playlist;
            $playlist->addSong($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): self
    {
        if ($this->playlists->removeElement($playlist)) {
            $playlist->removeSong($this);
        }

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

    /**
     * @return Collection|SongReaction[]
     */
    public function getSongReactions(): Collection
    {
        return $this->songReactions;
    }

    public function addSongReaction(SongReaction $songReaction): self
    {
        if (!$this->songReactions->contains($songReaction)) {
            $this->songReactions[] = $songReaction;
            $songReaction->setSong($this);
        }

        return $this;
    }

    public function removeSongReaction(SongReaction $songReaction): self
    {
        if ($this->songReactions->removeElement($songReaction)) {
            // set the owning side to null (unless already changed)
            if ($songReaction->getSong() === $this) {
                $songReaction->setSong(null);
            }
        }

        return $this;
    }
}
