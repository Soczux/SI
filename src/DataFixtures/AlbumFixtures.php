<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 *  Album fixtures
 */
class AlbumFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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
        $this->createMany(20, 'albums', function ($i) {
            $album = new Album();
            $album->setName($this->faker->sentence(rand(1, 3)));
            $album->setArtist($this->getRandomReference('artists'));
            $album->setLogoUrl($this->faker->imageUrl(640, 480, null, true, $album->getName()));

            return $album;
        });

        $manager->flush();
    }
}
