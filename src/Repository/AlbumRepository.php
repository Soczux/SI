<?php

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

    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial album.{id,name,logo_url}',
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

    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('album');
    }

    // /**
    //  * @return Album[] Returns an array of Album objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Album
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
