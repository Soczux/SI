<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
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
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="artists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=Song::class, mappedBy="artist")
     */
    private $songs;

    /**
     * @ORM\OneToMany(targetEntity=Album::class, mappedBy="artist")
     */
    private $albums;

    /**
     * @ORM\OneToMany(targetEntity=ArtistComment::class, mappedBy="artist", cascade={"persist"})
     */
    private $artistComments;

    /**
     * @ORM\OneToMany(targetEntity=ArtistReaction::class, mappedBy="artist")
     */
    private $artistReactions;

    /**
     * @ORM\ManyToMany(targetEntity=ArtistTag::class, inversedBy="artists")
     */
    private $tags;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->artistComments = new ArrayCollection();
        $this->artistReactions = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Song[]
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->setArtist($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getArtist() === $this) {
                $song->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getArtist() === $this) {
                $album->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArtistComment[]
     */
    public function getArtistComments(): Collection
    {
        return $this->artistComments;
    }

    public function addArtistComment(ArtistComment $artistComment): self
    {
        if (!$this->artistComments->contains($artistComment)) {
            $this->artistComments[] = $artistComment;
            $artistComment->setArtist($this);
        }

        return $this;
    }

    public function removeArtistComment(ArtistComment $artistComment): self
    {
        if ($this->artistComments->removeElement($artistComment)) {
            // set the owning side to null (unless already changed)
            if ($artistComment->getArtist() === $this) {
                $artistComment->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArtistReaction[]
     */
    public function getArtistReactions(): Collection
    {
        return $this->artistReactions;
    }

    public function addArtistReaction(ArtistReaction $artistReaction): self
    {
        if (!$this->artistReactions->contains($artistReaction)) {
            $this->artistReactions[] = $artistReaction;
            $artistReaction->setArtist($this);
        }

        return $this;
    }

    public function removeArtistReaction(ArtistReaction $artistReaction): self
    {
        if ($this->artistReactions->removeElement($artistReaction)) {
            // set the owning side to null (unless already changed)
            if ($artistReaction->getArtist() === $this) {
                $artistReaction->setArtist(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|ArtistTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(ArtistTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(ArtistTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
