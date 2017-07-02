<?php
namespace RecipeBundle\Security;

use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class FormAuthenticator
 * @package RecipeBundle\Security
 */
class FormAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * Message for authentication failure.
     *
     * @var string
     */
    private $authFailedMessage = 'Failed to log in';

    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    /**
     * Creates a new instance of FormAuthenticator
     * @param RouterInterface $router
     * @param UserPasswordEncoder $encoder
     */
    public function __construct(RouterInterface $router, UserPasswordEncoder $encoder)
    {
        $this->router  = $router;
        $this->encoder = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != $this->router->generate('login') || !$request->isMethod('POST')) {
            return;
        }

        return [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!$userProvider instanceof EntityUserProvider) {
            return;
        }

        $user = $userProvider->loadUserByUsername($credentials['username']);

        try {
            return $user;
        } catch (UsernameNotFoundException $e) {
            throw new CustomUserMessageAuthenticationException($this->authFailedMessage);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->encoder->isPasswordValid($user, $credentials['password'])) {
            return true;
        }

        throw new CustomUserMessageAuthenticationException($this->authFailedMessage);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $request->getSession()->remove(Security::LAST_USERNAME);

        return new RedirectResponse($this->router->generate('home'));
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::LAST_USERNAME, $request->request->get('username'));
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse($this->router->generate('login'));
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('login'));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
