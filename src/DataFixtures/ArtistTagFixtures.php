<?php

namespace App\DataFixtures;

use App\Entity\ArtistTag;
use Doctrine\Persistence\ObjectManager;

class ArtistTagFixtures extends AbstractBaseFixtures
{

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'tags', function () {
            $tag = new ArtistTag();
            $tag->setName($this->faker->word);

            return $tag;
        });

        $manager->flush();
    }
}