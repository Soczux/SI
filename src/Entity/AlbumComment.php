<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Entity;

use App\Repository\AlbumCommentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="albumComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Album $album;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="albumComments")
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $commentedOn;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Album|null
     */
    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    /**
     * @param Album|null $album
     *
     * @return $this
     */
    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCommentedOn(): ?DateTimeInterface
    {
        return $this->commentedOn;
    }

    /**
     * @param DateTimeInterface $commentedOn
     *
     * @return $this
     */
    public function setCommentedOn(DateTimeInterface $commentedOn): self
    {
        $this->commentedOn = $commentedOn;

        return $this;
    }
}
