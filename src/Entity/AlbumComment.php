<?php

namespace App\Entity;

use App\Repository\AlbumCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumCommentRepository::class)
 */
class AlbumComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="albumComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="albumComments")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commentedOn;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCommentedOn(): ?\DateTimeInterface
    {
        return $this->commentedOn;
    }

    public function setCommentedOn(\DateTimeInterface $commentedOn): self
    {
        $this->commentedOn = $commentedOn;

        return $this;
    }
}
