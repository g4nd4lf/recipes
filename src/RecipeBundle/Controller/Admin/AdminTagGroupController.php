<?php

namespace RecipeBundle\Controller\Admin;

use RecipeBundle\Entity\TagGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminTagGroupController
 * @package RecipeBundle\Controller
 *
 * @Route("admin/tag-group")
 */
class AdminTagGroupController extends Controller
{
    /**
     * Lists all tagGroup entities
     *
     * @Route("/", name="admin_tag_group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tagGroups = $em->getRepository('RecipeBundle:TagGroup')->findAll();

        return $this->render('RecipeBundle:admin/tag_group:index.html.twig', [
            'tagGroups' => $tagGroups,
        ]);
    }

    /**
     * Creates a new tagGroup entity
     *
     * @Route("/new", name="admin_tag_group_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $tagGroup = new TagGroup();
        $form = $this->createForm('RecipeBundle\Form\TagGroupType', $tagGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tagGroup);
            $em->flush($tagGroup);

            return $this->redirectToRoute('admin_tag_group_index');
        }

        return $this->render('RecipeBundle:admin/tag_group:new.html.twig', [
            'tagGroup' => $tagGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing tagGroup entity
     *
     * @Route("/{id}/edit", name="admin_tag_group_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param TagGroup $tagGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, TagGroup $tagGroup)
    {
        $deleteForm = $this->createDeleteForm($tagGroup);
        $editForm = $this->createForm('RecipeBundle\Form\TagGroupType', $tagGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tag_group_index');
        }

        return $this->render('RecipeBundle:admin/tag_group:edit.html.twig', [
            'tagGroup'    => $tagGroup,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a tagGroup entity.
     *
     * @Route("/{id}", name="admin_tag_group_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param TagGroup $tagGroup
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, TagGroup $tagGroup)
    {
        $form = $this->createDeleteForm($tagGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tagGroup);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tag_group_index');
    }

    /**
     * Creates a form to delete a tagGroup entity.
     *
     * @param TagGroup $tagGroup The tagGroup entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TagGroup $tagGroup)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tag_group_delete', ['id' => $tagGroup->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
