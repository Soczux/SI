<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\DataFixtures;

use App\Entity\Song;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 *  Song fixtures
 */
class SongFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(30, 'songs', function ($i) {
            $song = new Song();
            $song->setTitle($this->faker->sentence);
            $song->setArtist($this->getRandomReference('artists'));
            $song->setUrl($this->faker->url);

            return $song;
        });

        $manager->flush();
    }
}
