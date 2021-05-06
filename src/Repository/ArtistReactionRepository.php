<?php

namespace App\Repository;

use App\Entity\ArtistReaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistReaction[]    findAll()
 * @method ArtistReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistReaction::class);
    }

    // /**
    //  * @return ArtistReaction[] Returns an array of ArtistReaction objects
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
    public function findOneBySomeField($value): ?ArtistReaction
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
