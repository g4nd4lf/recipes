<?php
namespace RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RecipeBundle\Entity\Tag;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadTagData
 * @package RecipeBundle\DataFixtures\ORM
 */
class LoadTagData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'name' => 'Vegetarian',
                'group' => 'Diets',
            ],
            [
                'name' => 'Vegan',
                'group' => 'Diets',
            ],
            [
                'name' => 'Christmas',
                'group' => 'Events',
            ],
            [
                'name' => 'Cakes',
                'group' => 'Baking',
            ],
            [
                'name' => 'Buns',
                'group' => 'Baking',
            ],
            [
                'name' => 'Biscuits',
                'group' => 'Baking',
            ],
            [
                'name' => 'Peppers',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Onions',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Tomatoes',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Mexican',
                'group' => 'Cuisines',
            ],
            [
                'name' => 'Indian',
                'group' => 'Cuisines',
            ],
            [
                'name' => 'Italian',
                'group' => 'Cuisines',
            ],
            [
                'name' => 'Chinese',
                'group' => 'Cuisines',
            ],
            [
                'name' => 'Thai',
                'group' => 'Cuisines',
            ],
        ];

        $this->createFixtures($data, $manager);
    }

    /**
     * Create Fixtures
     *
     * @param array $data
     * @param ObjectManager $manager
     */
    private function createFixtures(array $data, ObjectManager $manager)
    {
        foreach ($data as $element) {
            $entity = new Tag();
            $entity->setName($element['name']);
            $entity->setTagGroup($this->getReference('TagGroup:' . $element['group']));

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
