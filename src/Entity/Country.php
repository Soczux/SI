<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Artist::class, mappedBy="country")
     */
    private Collection $artists;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="country")
     */
    private Collection $users;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private string $iso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Collection|Artist[]
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    /**
     * @param Artist $artist
     *
     * @return $this
     */
    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists[] = $artist;
            $artist->setCountry($this);
        }

        return $this;
    }

    /**
     * @param Artist $artist
     *
     * @return $this
     */
    public function removeArtist(Artist $artist): self
    {
        if ($this->artists->removeElement($artist)) {
            // set the owning side to null (unless already changed)
            if ($artist->getCountry() === $this) {
                $artist->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCountry($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCountry() === $this) {
                $user->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIso(): ?string
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     *
     * @return $this
     */
    public function setIso(string $iso): self
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
