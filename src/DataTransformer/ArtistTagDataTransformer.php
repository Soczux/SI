<?php

namespace App\DataTransformer;

use App\Entity\ArtistTag;
use App\Service\ArtistTagService;
use Symfony\Component\Form\DataTransformerInterface;

class ArtistTagDataTransformer implements DataTransformerInterface
{
    private ArtistTagService $artistTagService;

    public function __construct(ArtistTagService $artistTagService)
    {
        $this->artistTagService = $artistTagService;
    }

    public function transform($tags): string
    {
        if (null === $tags) {
            return '';
        }

        $tagNames = [];

        foreach ($tags as $tag) {
            $tagNames[] = $tag->getName();
        }

        return implode('.', $tagNames);
    }

    public function reverseTransform($value): array
    {
        $tagNames = explode(',', $value);

        $tags = [];

        foreach ($tagNames as $tagName) {
            if ('' !== trim($tagName)) {
                $tag = $this->artistTagService->findByTagName(strtolower($tagName));

                if (null === $tag) {
                    $tag = new ArtistTag();
                    $tag->setName($tagName);
                    $this->artistTagService->saveTag($tag);
                }

                $tags[] = $tag;
            }
        }

        return $tags;
    }
}