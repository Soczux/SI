<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Entity;

use App\Repository\ArtistTagRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArtistTagRepository::class)
 *
 * @UniqueEntity(fields={"name"})
 */
class ArtistTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $createdOn;

    /**
     * @ORM\ManyToMany(targetEntity=Artist::class, mappedBy="tags")
     */
    private Collection $artists;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artists = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
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
     * @return DateTimeInterface
     */
    public function getCreatedOn(): DateTimeInterface
    {
        return $this->createdOn;
    }

    /**
     * @param DateTimeInterface $createdOn
     *
     * @return $this
     */
    public function setCreatedOn(DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

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
            $artist->addTag($this);
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
            $artist->removeTag($this);
        }

        return $this;
    }
}
