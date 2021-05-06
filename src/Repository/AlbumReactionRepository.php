<?php

namespace App\Repository;

use App\Entity\AlbumReaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlbumReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumReaction[]    findAll()
 * @method AlbumReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumReaction::class);
    }

    // /**
    //  * @return AlbumReaction[] Returns an array of AlbumReaction objects
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
    public function findOneBySomeField($value): ?AlbumReaction
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
