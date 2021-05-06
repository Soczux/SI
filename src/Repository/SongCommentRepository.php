<?php

namespace App\Repository;

use App\Entity\SongComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SongComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongComment[]    findAll()
 * @method SongComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongComment::class);
    }

    // /**
    //  * @return SongComment[] Returns an array of SongComment objects
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
    public function findOneBySomeField($value): ?SongComment
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
