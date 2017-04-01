<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TagGroup;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Taggroup controller.
 *
 * @Route("admin/tag-group")
 */
class TagGroupController extends Controller
{
    /**
     * Lists all tagGroup entities.
     *
     * @Route("/", name="admin_tag-group_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tagGroups = $em->getRepository('AppBundle:TagGroup')->findAll();

        return $this->render('taggroup/index.html.twig', array(
            'tagGroups' => $tagGroups,
        ));
    }

    /**
     * Creates a new tagGroup entity.
     *
     * @Route("/new", name="admin_tag-group_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tagGroup = new Taggroup();
        $form = $this->createForm('AppBundle\Form\TagGroupType', $tagGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tagGroup);
            $em->flush($tagGroup);

            return $this->redirectToRoute('admin_tag-group_show', array('id' => $tagGroup->getId()));
        }

        return $this->render('taggroup/new.html.twig', array(
            'tagGroup' => $tagGroup,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tagGroup entity.
     *
     * @Route("/{id}", name="admin_tag-group_show")
     * @Method("GET")
     */
    public function showAction(TagGroup $tagGroup)
    {
        $deleteForm = $this->createDeleteForm($tagGroup);

        return $this->render('taggroup/show.html.twig', array(
            'tagGroup' => $tagGroup,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tagGroup entity.
     *
     * @Route("/{id}/edit", name="admin_tag-group_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TagGroup $tagGroup)
    {
        $deleteForm = $this->createDeleteForm($tagGroup);
        $editForm = $this->createForm('AppBundle\Form\TagGroupType', $tagGroup);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tag-group_edit', array('id' => $tagGroup->getId()));
        }

        return $this->render('taggroup/edit.html.twig', array(
            'tagGroup' => $tagGroup,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tagGroup entity.
     *
     * @Route("/{id}", name="admin_tag-group_delete")
     * @Method("DELETE")
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

        return $this->redirectToRoute('admin_tag-group_index');
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
            ->setAction($this->generateUrl('admin_tag-group_delete', array('id' => $tagGroup->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
