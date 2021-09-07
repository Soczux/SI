<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

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
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SongComment::class);
    }
}
