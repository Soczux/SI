<?php

namespace App\Service;

use App\Entity\ArtistTag;
use App\Repository\ArtistTagRepository;

class ArtistTagService
{
    private ArtistTagRepository $artistTagRepository;

    public function __construct(ArtistTagRepository $artistTagRepository)
    {
        $this->artistTagRepository = $artistTagRepository;
    }

    public function findByTagName(string $tagName): ?ArtistTag
    {
        return $this->artistTagRepository->findOneBy(['name' => $tagName]);
    }

    public function saveTag(ArtistTag $tag): void
    {
        $this->artistTagRepository->save($tag);
    }
}
