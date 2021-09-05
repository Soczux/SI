<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=320)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=Playlist::class, mappedBy="user")
     */
    private $playlists;

    /**
     * @ORM\OneToMany(targetEntity=AlbumComment::class, mappedBy="user")
     */
    private $albumComments;

    /**
     * @ORM\OneToMany(targetEntity=AlbumReaction::class, mappedBy="user")
     */
    private $albumReactions;

    /**
     * @ORM\OneToMany(targetEntity=ArtistComment::class, mappedBy="user")
     */
    private $artistComments;

    /**
     * @ORM\OneToMany(targetEntity=SongComment::class, mappedBy="user")
     */
    private $songComments;

    /**
     * @ORM\OneToMany(targetEntity=ArtistReaction::class, mappedBy="user")
     */
    private $artistReactions;

    /**
     * @ORM\OneToMany(targetEntity=SongReaction::class, mappedBy="user")
     */
    private $songReactions;

    public function __construct()
    {
        $this->playlists = new ArrayCollection();
        $this->albumComments = new ArrayCollection();
        $this->albumReactions = new ArrayCollection();
        $this->artistComments = new ArrayCollection();
        $this->songComments = new ArrayCollection();
        $this->artistReactions = new ArrayCollection();
        $this->songReactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
            $playlist->setUser($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): self
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getUser() === $this) {
                $playlist->setUser(null);
            }
        }

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
            $albumComment->setUser($this);
        }

        return $this;
    }

    public function removeAlbumComment(AlbumComment $albumComment): self
    {
        if ($this->albumComments->removeElement($albumComment)) {
            // set the owning side to null (unless already changed)
            if ($albumComment->getUser() === $this) {
                $albumComment->setUser(null);
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
            $albumReaction->setUser($this);
        }

        return $this;
    }

    public function removeAlbumReaction(AlbumReaction $albumReaction): self
    {
        if ($this->albumReactions->removeElement($albumReaction)) {
            // set the owning side to null (unless already changed)
            if ($albumReaction->getUser() === $this) {
                $albumReaction->setUser(null);
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
            $artistComment->setUser($this);
        }

        return $this;
    }

    public function removeArtistComment(ArtistComment $artistComment): self
    {
        if ($this->artistComments->removeElement($artistComment)) {
            // set the owning side to null (unless already changed)
            if ($artistComment->getUser() === $this) {
                $artistComment->setUser(null);
            }
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
            $songComment->setUser($this);
        }

        return $this;
    }

    public function removeSongComment(SongComment $songComment): self
    {
        if ($this->songComments->removeElement($songComment)) {
            // set the owning side to null (unless already changed)
            if ($songComment->getUser() === $this) {
                $songComment->setUser(null);
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
            $artistReaction->setUser($this);
        }

        return $this;
    }

    public function removeArtistReaction(ArtistReaction $artistReaction): self
    {
        if ($this->artistReactions->removeElement($artistReaction)) {
            // set the owning side to null (unless already changed)
            if ($artistReaction->getUser() === $this) {
                $artistReaction->setUser(null);
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
            $songReaction->setUser($this);
        }

        return $this;
    }

    public function removeSongReaction(SongReaction $songReaction): self
    {
        if ($this->songReactions->removeElement($songReaction)) {
            // set the owning side to null (unless already changed)
            if ($songReaction->getUser() === $this) {
                $songReaction->setUser(null);
            }
        }

        return $this;
    }
}
