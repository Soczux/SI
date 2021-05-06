<?php

namespace App\Repository;

use App\Entity\AlbumComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlbumComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumComment[]    findAll()
 * @method AlbumComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumComment::class);
    }

    // /**
    //  * @return AlbumComment[] Returns an array of AlbumComment objects
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
    public function findOneBySomeField($value): ?AlbumComment
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
