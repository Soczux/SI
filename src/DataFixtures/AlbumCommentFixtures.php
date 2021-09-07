<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\DataFixtures;

use App\Entity\AlbumComment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 *  Album comment fixtures
 */
class AlbumCommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     */
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
