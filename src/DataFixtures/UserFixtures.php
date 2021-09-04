<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public const ADMIN_REFERENCE = 'admin';
    public const USER_REFERENCE = 'user';
    public const USER1_REFERENCE = 'user1';

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getDependencies(): array
    {
        return [
            CountryFixture::class,
        ];
    }

    protected function loadData(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'admin'));
        $admin->setEmail($this->faker->email);
        $admin->setCountry($this->getRandomReference('countries'));
        $manager->persist($admin);

        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
        $user->setEmail($this->faker->email);
        $user->setCountry($this->getRandomReference('countries'));
        $manager->persist($user);

        $user1 = new User();
        $user1->setUsername($this->faker->userName);
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, $this->faker->password));
        $user1->setEmail($this->faker->email);
        $user1->setCountry($this->getRandomReference('countries'));
        $manager->persist($user1);

        $manager->flush();

        $this->addReference(self::ADMIN_REFERENCE, $admin);
        $this->addReference(self::USER_REFERENCE, $user);
        $this->addReference(self::USER1_REFERENCE, $user1);
    }
}
