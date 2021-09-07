<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistComment::class);
    }
}
