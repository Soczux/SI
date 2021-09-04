<?php

namespace App\DataFixtures;

use App\Entity\AlbumComment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AlbumCommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'albums_comments', function ($i) {
            $usersReferences = [
                UserFixtures::ADMIN_REFERENCE,
                UserFixtures::USER_REFERENCE,
                UserFixtures::USER1_REFERENCE,
            ];

            $comment = new AlbumComment();
            $comment->setAlbum($this->getRandomReference('albums'));
            $comment->setUser($this->getReference($usersReferences[$i % 3]));
            $comment->setContent($this->faker->sentence(50));
            $comment->setCommentedOn($this->faker->dateTimeBetween('-100 days', 'now'));

            return $comment;
        });

        $manager->flush();
    }
}
