<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Service;

use App\Entity\Artist;
use App\Entity\ArtistComment;
use App\Repository\ArtistRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Artist service
 */
class ArtistService
{
    private ArtistRepository $artistRepository;

    private PaginatorInterface $paginator;

    /**
     * @param ArtistRepository   $artistRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(ArtistRepository $artistRepository, PaginatorInterface $paginator)
    {
        $this->artistRepository = $artistRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param Artist $artist
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function saveArtist(Artist $artist): void
    {
        $this->artistRepository->save($artist);
    }

    /**
     * @param Artist $artist
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteArtist(Artist $artist): void
    {
        $this->artistRepository->delete($artist);
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
            $this->artistRepository->queryAll($filters),
            $page,
            ArtistRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param Artist        $artist
     * @param ArtistComment $comment
     * @param UserInterface $user
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addComment(Artist $artist, ArtistComment $comment, UserInterface $user): void
    {
        $comment->setUser($user);
        $artist->addArtistComment($comment);
        $this->saveArtist($artist);
    }
}
