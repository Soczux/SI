<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=SongReaction::class, mappedBy="reaction")
     */
    private $songReactions;

    public function __construct()
    {
        $this->songReactions = new ArrayCollection();
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
            $songReaction->setReaction($this);
        }

        return $this;
    }

    public function removeSongReaction(SongReaction $songReaction): self
    {
        if ($this->songReactions->removeElement($songReaction)) {
            // set the owning side to null (unless already changed)
            if ($songReaction->getReaction() === $this) {
                $songReaction->setReaction(null);
            }
        }

        return $this;
    }
}
