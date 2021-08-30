<?php

namespace App\Repository;

use App\Entity\ArtistTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistTag[]    findAll()
 * @method ArtistTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistTag::class);
    }

    public function save(ArtistTag $artistTag)
    {
        $this->_em->persist($artistTag);
        $this->_em->flush();
    }

    public function delete(ArtistTag $artistTag)
    {
        $this->_em->remove($artistTag);
        $this->_em->flush();
    }

    // /**
    //  * @return ArtistTag[] Returns an array of ArtistTag objects
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
    public function findOneBySomeField($value): ?ArtistTag
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
