<?php
namespace RecipeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RecipeBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package RecipeBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
                'username'  => 'admin',
                'password'  => 'recipesareawesome',
                'email'     => 'admin@recipes.co.uk',
                'firstname' => 'Admin',
                'lastname'  => 'User',
                'roles'     => ['ROLE_ADMIN_ACCESS'],
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
            $entity = new User();
            $encoder = $this->container->get('security.password_encoder');

            $entity
                ->setUsername($element['username'])
                ->setPassword($encoder->encodePassword($entity, $element['password']))
                ->setEmail($element['email'])
                ->setFirstName($element['firstname'])
                ->setLastName($element['lastname']);

            foreach ($element['roles'] as $role) {
                $entity->addRole($this->getReference('Role:' . $role));
            }

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
