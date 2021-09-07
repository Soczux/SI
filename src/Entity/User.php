<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     *
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=320)
     */
    private string $email;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     */
    private Country $country;

    /**
     * @ORM\OneToMany(targetEntity=AlbumComment::class, mappedBy="user", cascade={"remove", "persist"})
     */
    private Collection $albumComments;

    /**
     * @ORM\OneToMany(targetEntity=ArtistComment::class, mappedBy="user", cascade={"remove", "persist"})
     */
    private Collection $artistComments;

    /**
     * @ORM\OneToMany(targetEntity=SongComment::class, mappedBy="user", cascade={"remove", "persist"})
     */
    private Collection $songComments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->albumComments = new ArrayCollection();
        $this->artistComments = new ArrayCollection();
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
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
     *
     * @return string|null
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

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country ?? null;
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
            $albumComment->setUser($this);
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
            if ($albumComment->getUser() === $this) {
                $albumComment->setUser(null);
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
            $artistComment->setUser($this);
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

    /**
     * @param SongComment $songComment
     *
     * @return $this
     */
    public function addSongComment(SongComment $songComment): self
    {
        if (!$this->songComments->contains($songComment)) {
            $this->songComments[] = $songComment;
            $songComment->setUser($this);
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
            if ($songComment->getUser() === $this) {
                $songComment->setUser(null);
            }
        }

        return $this;
    }
}
