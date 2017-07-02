<?php
namespace RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RecipeBundle\Entity\Role;

/**
 * Class LoadRoleData
 * @package RecipeBundle\DataFixtures\ORM
 */
class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
                'role'        => 'ROLE_GUEST_ACCESS',
                'description' => 'Guest Access',
            ],
            [
                'role'        => 'ROLE_ADMIN_ACCESS',
                'description' => 'Admin Access',
            ],
            [
                'role'        => 'ROLE_AUTHOR_ACCESS',
                'description' => 'Recipe Author Access',
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
            $entity = new Role();
            $entity->setRole($element['role']);
            $entity->setDescription($element['description']);

            $this->addReference('Role:' . $element['role'], $entity);

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
