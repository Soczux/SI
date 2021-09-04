<?php

namespace App\DataFixtures;

use App\Entity\Song;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SongFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
        ];
    }

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
