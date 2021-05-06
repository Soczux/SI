<?php

namespace App\Entity;

use App\Repository\SongReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SongReactionRepository::class)
 */
class SongReaction
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Song::class, inversedBy="songReactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $song;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="songReactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Reaction::class, inversedBy="songReactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSong(): ?Song
    {
        return $this->song;
    }

    public function setSong(?Song $song): self
    {
        $this->song = $song;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReaction(): ?Reaction
    {
        return $this->reaction;
    }

    public function setReaction(?Reaction $reaction): self
    {
        $this->reaction = $reaction;

        return $this;
    }
}
