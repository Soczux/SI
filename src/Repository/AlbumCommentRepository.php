<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumComment::class);
    }
}
