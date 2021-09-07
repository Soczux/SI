<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use LogicException;

/**
 *  Abstract base fixtures
 */
abstract class AbstractBaseFixtures extends Fixture
{
    protected Generator $faker;

    protected ObjectManager $manager;

    private array $referencesIndex = [];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    abstract protected function loadData(ObjectManager $manager): void;

    /**
     * @param int      $count
     * @param string   $groupName
     * @param callable $factory
     */
    protected function createMany(int $count, string $groupName, callable $factory): void
    {
        for ($i = 0; $i < $count; ++$i) {
            $entity = $factory($i);

            if (null === $entity) {
                throw new LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }

            $this->manager->persist($entity);

            // store for usage later as groupName_#COUNT#
            $this->addReference(sprintf('%s_%d', $groupName, $i), $entity);
        }
    }

    /**
     * @param string $groupName
     * @param int    $count
     *
     * @return array
     */
    protected function getRandomReferences(string $groupName, int $count): array
    {
        $references = [];
        while (count($references) < $count) {
            $references[] = $this->getRandomReference($groupName);
        }

        return $references;
    }

    /**
     * @param string $groupName
     *
     * @return object
     */
    protected function getRandomReference(string $groupName): object
    {
        if (!isset($this->referencesIndex[$groupName])) {
            $this->referencesIndex[$groupName] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $reference) {
                if (0 === strpos($key, $groupName.'_')) {
                    $this->referencesIndex[$groupName][] = $key;
                }
            }
        }

        if (empty($this->referencesIndex[$groupName])) {
            throw new InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"', $groupName));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$groupName]);

        return $this->getReference($randomReferenceKey);
    }
}
