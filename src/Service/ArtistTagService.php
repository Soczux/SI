<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Service;

use App\Entity\ArtistTag;
use App\Repository\ArtistTagRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Artist tag service
 */
class ArtistTagService
{
    private ArtistTagRepository $artistTagRepository;

    /**
     * @param ArtistTagRepository $artistTagRepository
     */
    public function __construct(ArtistTagRepository $artistTagRepository)
    {
        $this->artistTagRepository = $artistTagRepository;
    }

    /**
     * @param string $tagName
     *
     * @return ArtistTag|null
     */
    public function findByTagName(string $tagName): ?ArtistTag
    {
        return $this->artistTagRepository->findOneBy(['name' => $tagName]);
    }

    /**
     * @param ArtistTag $tag
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveTag(ArtistTag $tag): void
    {
        $this->artistTagRepository->save($tag);
    }
}
