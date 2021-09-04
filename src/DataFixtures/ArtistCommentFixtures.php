<?php

namespace App\DataFixtures;

use App\Entity\ArtistComment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistCommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ArtistFixtures::class,
        ];
    }

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'artist_comments', function ($i) {
            $usersReferences = [
                UserFixtures::ADMIN_REFERENCE,
                UserFixtures::USER_REFERENCE,
                UserFixtures::USER1_REFERENCE,
            ];

            $comment = new ArtistComment();
            $comment->setArtist($this->getRandomReference('artists'));
            $comment->setUser($this->getReference($usersReferences[$i % 3]));
            $comment->setContent($this->faker->sentence(50));
            $comment->setCommentedOn($this->faker->dateTimeBetween('-100 days', 'now'));

            return $comment;
        });

        $manager->flush();
    }
}
