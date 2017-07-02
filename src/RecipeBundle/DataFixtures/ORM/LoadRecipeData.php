<?php
namespace RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RecipeBundle\Entity\Recipe;

/**
 * Class LoadRecipeData
 * @package RecipeBundle\DataFixtures\ORM
 */
class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
                'name'          => 'Basic Tomato Soup',
                'summary'       => 'A soup rich in tomatoes, but not much else.',
                'method'        => 'Chop up tomatoes, add into the pan along with the vegetable stock. ' .
                                   'Stir a bit and don\'t let things burn. ' .
                                   'Add salt and pepper if that floats your boat.',
                'ingredients'   => 'Tomatoes, vegetable stock.',
                'servings'      => '1',
                'prepTime'      => '3',
                'cookingTime'   => '5',
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
            $entity = new Recipe();
            $entity
                ->setName($element['name'])
                ->setSummary($element['summary'])
                ->setMethod($element['method'])
                ->setIngredients($element['ingredients'])
                ->setServings($element['servings'])
                ->setPrepTime($element['prepTime'])
                ->setCookingTime($element['cookingTime']);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
