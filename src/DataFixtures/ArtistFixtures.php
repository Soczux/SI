<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            CountryFixture::class,
            ArtistTagFixtures::class,
        ];
    }

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(30, 'artists', function ($i) {
            $artist = new Artist();
            $artist->setCountry($this->getRandomReference('countries'));
            $artist->setName($this->faker->name);

            $tagCounter = rand(1, 5);

            for ($i = 0; $i < $tagCounter; $i++) {
                $artist->addTag($this->getRandomReference('tags'));
            }

            return $artist;
        });

        $manager->flush();
    }
}
