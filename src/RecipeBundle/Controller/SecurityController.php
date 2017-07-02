<?php

namespace RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SecurityController
 * @package RecipeBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * Log in a user
     *
     * @return RedirectResponse|Response
     */
    public function loginAction()
    {
        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            return $this->redirectToRoute('home');
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        $exception           = $authenticationUtils->getLastAuthenticationError();
        $lastUsername        = $authenticationUtils->getLastUsername();

        if ($exception) {
            $this->addFlash('notice', $exception->getMessage());
        }

        return $this->render(
            'RecipeBundle:security:login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $exception ? $exception->getMessage() : null
            ]
        );
    }
}
