<?php

namespace App\Repository;

use App\Entity\ArtistComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistComment[]    findAll()
 * @method ArtistComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistComment::class);
    }

    // /**
    //  * @return ArtistComment[] Returns an array of ArtistComment objects
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
    public function findOneBySomeField($value): ?ArtistComment
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
