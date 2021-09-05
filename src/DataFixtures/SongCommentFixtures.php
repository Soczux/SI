<?php

namespace App\DataFixtures;

use App\Entity\SongComment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SongCommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SongFixtures::class,
        ];
    }

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'song_comments', function ($i) {
            $usersReferences = [
                UserFixtures::ADMIN_REFERENCE,
                UserFixtures::USER_REFERENCE,
                UserFixtures::USER1_REFERENCE,
            ];

            $comment = new SongComment();
            $comment->setSong($this->getRandomReference('songs'));
            $comment->setUser($this->getReference($usersReferences[$i % 3]));
            $comment->setContent($this->faker->sentence(50));
            $comment->setCommentedOn($this->faker->dateTimeBetween('-100 days', 'now'));

            return $comment;
        });

        $manager->flush();
    }
}
