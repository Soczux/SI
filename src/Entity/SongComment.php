<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Entity;

use App\Repository\SongCommentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=SongCommentRepository::class)
 */
class SongComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Song::class, inversedBy="songComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Song $song;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="songComments")
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
     * @return Song|null
     */
    public function getSong(): ?Song
    {
        return $this->song;
    }

    /**
     * @param Song|null $song
     *
     * @return $this
     */
    public function setSong(?Song $song): self
    {
        $this->song = $song;

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
