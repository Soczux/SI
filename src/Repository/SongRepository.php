<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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

    /**
     * @param ManagerRegistry $registry
     */
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

    /**
     * @param array $filters
     *
     * @return QueryBuilder
     */
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

    /**
     * @param QueryBuilder|null $queryBuilder
     *
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('song');
    }
}
