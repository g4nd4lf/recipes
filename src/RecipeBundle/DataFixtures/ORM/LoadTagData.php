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
        $diet = [
            [
                'name' => 'Vegetarian',
                'group' => 'Diet',
            ],
            [
                'name' => 'Vegan',
                'group' => 'Diet',
            ],
            [
                'name' => 'Healthy',
                'group' => 'Diet',
            ],
        ];

        $seasonal = [
            [
                'name' => 'Christmas',
                'group' => 'Seasonal',
            ],
            [
                'name' => 'Easter',
                'group' => 'Seasonal',
            ],
            [
                'name' => 'Bonfire Night',
                'group' => 'Seasonal',
            ],
            [
                'name' => 'Halloween',
                'group' => 'Seasonal',
            ],
        ];

        $baking = [
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
        ];

        $ingredients = [
            [
                'name' => 'Bread',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Cheese',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Chocolate',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Eggs',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Fruit',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Onions',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Pasta',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Peppers',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Potatoes',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Rice',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Tomatoes',
                'group' => 'Ingredients',
            ],
            [
                'name' => 'Vegetables',
                'group' => 'Ingredients',
            ],
        ];

        $cuisines = [
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
            [
                'name' => 'Russian',
                'group' => 'Cuisines',
            ],
            [
                'name' => 'African',
                'group' => 'Cuisines',
            ],
        ];


        $courses = [
            [
                'name' => 'Breakfast',
                'group' => 'Courses',
            ],
            [
                'name' => 'Brunch',
                'group' => 'Courses',
            ],
            [
                'name' => 'Desserts',
                'group' => 'Courses',
            ],
            [
                'name' => 'Main Meals',
                'group' => 'Courses',
            ],
            [
                'name' => 'Lunches',
                'group' => 'Courses',
            ],
            [
                'name' => 'Salads',
                'group' => 'Courses',
            ],
            [
                'name' => 'Sauces',
                'group' => 'Courses',
            ],
            [
                'name' => 'Snacks',
                'group' => 'Courses',
            ],
            [
                'name' => 'Sandwiches',
                'group' => 'Courses',
            ],
            [
                'name' => 'Starters',
                'group' => 'Courses',
            ],
        ];


        $data = array_merge($diet, $seasonal, $baking, $ingredients, $cuisines, $courses);

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
