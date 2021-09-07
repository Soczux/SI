<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 *  Artist fixtures
 */
class ArtistFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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
            CountryFixture::class,
            ArtistTagFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(30, 'artists', function ($i) {
            $artist = new Artist();
            $artist->setCountry($this->getRandomReference('countries'));
            $artist->setName($this->faker->name);

            $tagCounter = rand(1, 5);

            for ($i = 0; $i < $tagCounter; ++$i) {
                $artist->addTag($this->getRandomReference('tags'));
            }

            return $artist;
        });

        $manager->flush();
    }
}
