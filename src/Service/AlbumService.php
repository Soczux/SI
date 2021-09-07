<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Service;

use App\Entity\Album;
use App\Entity\AlbumComment;
use App\Repository\AlbumRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Album service
 */
class AlbumService
{
    private AlbumRepository $albumRepository;

    private PaginatorInterface $paginator;

    /**
     * @param AlbumRepository    $albumRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(AlbumRepository $albumRepository, PaginatorInterface $paginator)
    {
        $this->albumRepository = $albumRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param Album $album
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveAlbum(Album $album): void
    {
        $this->albumRepository->save($album);
    }

    /**
     * @param Album $album
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteAlbum(Album $album): void
    {
        $this->albumRepository->delete($album);
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
            $this->albumRepository->queryAll($filters),
            $page,
            AlbumRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param Album         $album
     * @param AlbumComment  $comment
     * @param UserInterface $user
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addComment(Album $album, AlbumComment $comment, UserInterface $user): void
    {
        $comment->setUser($user);
        $album->addAlbumComment($comment);
        $this->saveAlbum($album);
    }
}
