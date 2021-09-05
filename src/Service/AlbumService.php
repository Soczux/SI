<?php

namespace App\Service;

use App\Entity\Album;
use App\Entity\AlbumComment;
use App\Repository\AlbumRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AlbumService
{
    private $albumRepository;

    private $paginator;

    public function __construct(AlbumRepository $albumRepository, PaginatorInterface $paginator)
    {
        $this->albumRepository = $albumRepository;
        $this->paginator = $paginator;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveAlbum(Album $album)
    {
        $this->albumRepository->save($album);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteAlbum(Album $album)
    {
        $this->albumRepository->delete($album);
    }

    public function createPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->albumRepository->queryAll($filters),
            $page,
            AlbumRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function addComment(Album $album, AlbumComment $comment, UserInterface $user)
    {
        $comment->setUser($user);
        $album->addAlbumComment($comment);
        $this->saveAlbum($album);
    }
}
