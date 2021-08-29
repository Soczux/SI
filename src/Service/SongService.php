<?php

namespace App\Service;

use App\Entity\Song;
use App\Entity\SongComment;
use App\Repository\SongRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SongService
{
    private $songRepository;

    private $paginator;

    public function __construct(SongRepository $songRepository, PaginatorInterface $paginator) {
        $this->songRepository = $songRepository;
        $this->paginator = $paginator;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveSong(Song $song) {
        $this->songRepository->save($song);
    }

    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->songRepository->findAll(),
            $page,
            SongRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function addComment(Song $song, SongComment $comment, UserInterface $user)
    {
        $comment->setUser($user);
        $song->addSongComment($comment);
        $this->saveSong($song);
    }
}