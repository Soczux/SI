<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    private int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $logoUrl;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private Artist $artist;

    /**
     * @ORM\OneToMany(targetEntity=AlbumComment::class, mappedBy="album", cascade={"remove", "persist"})
     */
    private Collection $albumComments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->albumComments = new ArrayCollection();
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
     * @return string|null
     */
    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    /**
     * @param string $logoUrl
     *
     * @return $this
     */
    public function setLogoUrl(string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;

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
     * @return Collection|AlbumComment[]
     */
    public function getAlbumComments(): Collection
    {
        return $this->albumComments;
    }

    /**
     * @param AlbumComment $albumComment
     *
     * @return $this
     */
    public function addAlbumComment(AlbumComment $albumComment): self
    {
        if (!$this->albumComments->contains($albumComment)) {
            $this->albumComments[] = $albumComment;
            $albumComment->setAlbum($this);
        }

        return $this;
    }

    /**
     * @param AlbumComment $albumComment
     *
     * @return $this
     */
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
