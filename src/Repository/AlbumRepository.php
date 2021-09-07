<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 15;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @param Album $album Album to add
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Album $album): void
    {
        $this->_em->persist($album);
        $this->_em->flush();
    }

    /**
     * @param Album $album Album to delete
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Album $album): void
    {
        $this->_em->remove($album);
        $this->_em->flush();
    }

    /**
     * @param array $filters
     *
     * @return QueryBuilder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial album.{id,name,logoUrl}',
                'partial artist.{id,name}'
            )
            ->leftJoin('album.artist', 'artist')
        ;

        if (array_key_exists('artist_id', $filters) && $filters['artist_id'] > 0) {
            $queryBuilder
                ->andWhere('artist IN (:artist_id)')
                ->setParameter('artist_id', $filters['artist_id'])
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder|null $queryBuilder
     *
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('album');
    }
}
