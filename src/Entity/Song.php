<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     */
    private Artist $artist;

    /**
     * @ORM\OneToMany(targetEntity=SongComment::class, mappedBy="song", cascade={"remove", "persist"})
     */
    private Collection $songComments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->songComments = new ArrayCollection();
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Artist|null
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @param Artist|null $artist
     *
     * @return $this
     */
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

    /**
     * @param SongComment $songComment
     *
     * @return $this
     */
    public function addSongComment(SongComment $songComment): self
    {
        if (!$this->songComments->contains($songComment)) {
            $this->songComments[] = $songComment;
            $songComment->setSong($this);
        }

        return $this;
    }

    /**
     * @param SongComment $songComment
     *
     * @return $this
     */
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
