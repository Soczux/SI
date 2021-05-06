<?php

namespace App\Repository;

use App\Entity\SongReaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SongReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method SongReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method SongReaction[]    findAll()
 * @method SongReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongReaction::class);
    }

    // /**
    //  * @return SongReaction[] Returns an array of SongReaction objects
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
    public function findOneBySomeField($value): ?SongReaction
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
