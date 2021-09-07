<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\DataFixtures;

use App\Entity\ArtistTag;
use Doctrine\Persistence\ObjectManager;

/**
 * Artist tag fixtures
 */
class ArtistTagFixtures extends AbstractBaseFixtures
{
    /**
     * @param ObjectManager $manager
     */
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
