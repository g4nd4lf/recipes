<?php

namespace RecipeBundle\Controller\Admin;

use RecipeBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminTagController
 * @package RecipeBundle\Controller
 *
 * @Route("admin/tag")
 */
class AdminTagController extends Controller
{
    /**
     * Lists all tag entities
     *
     * @Route("/", name="admin_tag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('RecipeBundle:Tag')->findAll();

        return $this->render('RecipeBundle:admin/tag:index.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * Creates a new tag entity
     *
     * @Route("/new", name="admin_tag_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm('RecipeBundle\Form\TagType', $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush($tag);

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('RecipeBundle:admin/tag:new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing tag entity
     *
     * @Route("/{id}/edit", name="admin_tag_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm('RecipeBundle\Form\TagType', $tag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('RecipeBundle:admin/tag:edit.html.twig', array(
            'tag'         => $tag,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tag entity
     *
     * @Route("/{id}", name="admin_tag_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tag_index');
    }

    /**
     * Creates a form to delete a tag entity
     *
     * @param Tag $tag The tag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tag_delete', ['id' => $tag->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
