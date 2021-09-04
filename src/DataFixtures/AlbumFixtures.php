<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AlbumFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
        ];
    }

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(20, 'albums', function ($i) {
            $album = new Album();
            $album->setName($this->faker->sentence(rand(1,3)));
            $album->setArtist($this->getRandomReference('artists'));
            $album->setLogoUrl($this->faker->imageUrl(640, 480, null, true, $album->getName()));

            return $album;
        });

        $manager->flush();
    }
}
