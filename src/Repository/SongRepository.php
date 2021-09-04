<?php

namespace App\Repository;

use App\Entity\Song;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Song|null find($id, $lockMode = null, $lockVersion = null)
 * @method Song|null findOneBy(array $criteria, array $orderBy = null)
 * @method Song[]    findAll()
 * @method Song[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongRepository extends ServiceEntityRepository
{
    const PAGINATOR_ITEMS_PER_PAGE = 12;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    /**
     * @param Song $song Song to add
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Song $song): void
    {
        $this->_em->persist($song);
        $this->_em->flush();
    }

    /**
     * @param Song $song Song to add
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(Song $song): void
    {
        $this->_em->remove($song);
        $this->_em->flush();
    }

    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial song.{id, title, url}',
                'partial artist.{id, name}'
            )
            ->leftJoin('song.artist', 'artist')
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
        return $queryBuilder ?? $this->createQueryBuilder('song');
    }

    // /**
    //  * @return Song[] Returns an array of Song objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Song
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
