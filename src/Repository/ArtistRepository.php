<?php

namespace App\Repository;

use App\Entity\Artist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artist[]    findAll()
 * @method Artist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 8;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artist::class);
    }

    /**
     * @param Artist $artist Artist to add
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Artist $artist): void
    {
        $this->_em->persist($artist);
        $this->_em->flush();
    }

    /**
     * @param Artist $artist Artist to delete
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Artist $artist): void
    {
        $this->_em->remove($artist);
        $this->_em->flush();
    }

    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial artist.{id,name}',
                'partial tags.{id,name}'
            )
            ->leftJoin('artist.tags', 'tags')
        ;

        if (array_key_exists('tag_id', $filters) && $filters['tag_id'] > 0) {
            $queryBuilder
                ->andWhere('tags IN (:tag_id)')
                ->setParameter('tag_id', $filters['tag_id'])
            ;
        }

        return $queryBuilder;
    }

    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('artist');
    }

    // /**
    //  * @return Artist[] Returns an array of Artist objects
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
    public function findOneBySomeField($value): ?Artist
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
