<?php

namespace App\Entity;

use App\Repository\AlbumReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumReactionRepository::class)
 */
class AlbumReaction
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="albumReactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="albumReactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Reaction::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $reaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

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
