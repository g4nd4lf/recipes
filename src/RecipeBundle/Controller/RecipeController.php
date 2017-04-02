<?php

namespace RecipeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RecipeController
 * @package RecipeBundle\Controller
 */
class RecipeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('RecipeBundle:Recipe')->findAll();

        return $this->render('RecipeBundle::recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }
}
