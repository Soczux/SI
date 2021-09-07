<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Service;

use App\Entity\Song;
use App\Entity\SongComment;
use App\Repository\SongRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Song service
 */
class SongService
{
    private SongRepository $songRepository;

    private PaginatorInterface $paginator;

    /**
     * @param SongRepository     $songRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(SongRepository $songRepository, PaginatorInterface $paginator)
    {
        $this->songRepository = $songRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param Song $song
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveSong(Song $song): void
    {
        $this->songRepository->save($song);
    }

    /**
     * @param Song $song
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteSong(Song $song): void
    {
        $this->songRepository->delete($song);
    }

    /**
     * @param int   $page
     * @param array $filters
     *
     * @return PaginationInterface
     */
    public function createPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->songRepository->queryAll($filters),
            $page,
            SongRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param Song          $song
     * @param SongComment   $comment
     * @param UserInterface $user
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addComment(Song $song, SongComment $comment, UserInterface $user): void
    {
        $comment->setUser($user);
        $song->addSongComment($comment);
        $this->saveSong($song);
    }
}
