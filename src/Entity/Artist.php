<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="artists")
     * @ORM\JoinColumn(nullable=false)
     */
    private Country $country;

    /**
     * @ORM\OneToMany(targetEntity=Song::class, mappedBy="artist")
     */
    private Collection $songs;

    /**
     * @ORM\OneToMany(targetEntity=Album::class, mappedBy="artist")
     */
    private Collection $albums;

    /**
     * @ORM\OneToMany(targetEntity=ArtistComment::class, mappedBy="artist", cascade={"remove", "persist"})
     */
    private Collection $artistComments;

    /**
     * @ORM\ManyToMany(targetEntity=ArtistTag::class, inversedBy="artists")
     */
    private Collection $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->songs = new ArrayCollection();
        $this->albums = new ArrayCollection();
        $this->artistComments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country|null $country
     *
     * @return $this
     */
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

    /**
     * @param Song $song
     *
     * @return $this
     */
    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->setArtist($this);
        }

        return $this;
    }

    /**
     * @param Song $song
     *
     * @return $this
     */
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

    /**
     * @param Album $album
     *
     * @return $this
     */
    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setArtist($this);
        }

        return $this;
    }

    /**
     * @param Album $album
     *
     * @return $this
     */
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

    /**
     * @param ArtistComment $artistComment
     *
     * @return $this
     */
    public function addArtistComment(ArtistComment $artistComment): self
    {
        if (!$this->artistComments->contains($artistComment)) {
            $this->artistComments[] = $artistComment;
            $artistComment->setArtist($this);
        }

        return $this;
    }

    /**
     * @param ArtistComment $artistComment
     *
     * @return $this
     */
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
     * @return string
     */
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

    /**
     * @param ArtistTag $tag
     *
     * @return $this
     */
    public function addTag(ArtistTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * @param ArtistTag $tag
     *
     * @return $this
     */
    public function removeTag(ArtistTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
