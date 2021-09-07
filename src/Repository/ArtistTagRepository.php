<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Repository;

use App\Entity\ArtistTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistTag[]    findAll()
 * @method ArtistTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistTagRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistTag::class);
    }

    /**
     * @param ArtistTag $artistTag
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ArtistTag $artistTag)
    {
        $this->_em->persist($artistTag);
        $this->_em->flush();
    }

    /**
     * @param ArtistTag $artistTag
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(ArtistTag $artistTag)
    {
        $this->_em->remove($artistTag);
        $this->_em->flush();
    }
}
