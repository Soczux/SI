<?php

namespace App\Service;

use App\Entity\AlbumComment;
use App\Entity\Artist;
use App\Entity\ArtistComment;
use App\Repository\ArtistRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ArtistService
{
    private $artistRepository;

    private $paginator;

    public function __construct(ArtistRepository $artistRepository, PaginatorInterface $paginator)
    {
        $this->artistRepository = $artistRepository;
        $this->paginator = $paginator;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveArtist(Artist $artist)
    {
        $this->artistRepository->save($artist);
    }

    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->artistRepository->findAll(),
            $page,
            ArtistRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function addComment(Artist $artist, ArtistComment $comment, UserInterface $user)
    {
        $comment->setUser($user);
        $artist->addArtistComment($comment);
        $this->saveArtist($artist);
    }
}