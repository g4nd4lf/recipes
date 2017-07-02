<?php

namespace RecipeBundle\Controller\Admin;

use RecipeBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminRecipeController
 * @package RecipeBundle\Controller
 *
 * @Route("/admin/recipes")
 */
class AdminRecipeController extends Controller
{
    /**
     * Lists all recipe entities
     *
     * @Route("/", name="admin_recipe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recipes = $em->getRepository('RecipeBundle:Recipe')->findAll();

        return $this->render('RecipeBundle:admin/recipe:index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    /**
     * Creates a new recipe entity
     *
     * @Route("/new", name="admin_recipe_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm('RecipeBundle\Form\RecipeType', $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush($recipe);

            return $this->redirectToRoute('admin_recipe_index');
        }

        return $this->render('RecipeBundle:admin/recipe:new.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a recipe entity
     *
     * @Route("/{id}", name="admin_recipe_show")
     * @Method("GET")
     * @param Recipe $recipe
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);

        return $this->render('RecipeBundle:admin/recipe:show.html.twig', array(
            'recipe' => $recipe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing recipe entity
     *
     * @Route("/{id}/edit", name="admin_recipe_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Recipe $recipe
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);
        $editForm = $this->createForm('RecipeBundle\Form\RecipeType', $recipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_recipe_index');
        }

        return $this->render('RecipeBundle:admin/recipe:edit.html.twig', [
            'recipe'      => $recipe,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a recipe entity
     *
     * @Route("/{id}", name="admin_recipe_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Recipe $recipe
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $form = $this->createDeleteForm($recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirectToRoute('admin_recipe_index');
    }

    /**
     * Creates a form to delete a recipe entity
     *
     * @param Recipe $recipe The recipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recipe $recipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_recipe_delete', ['id' => $recipe->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
