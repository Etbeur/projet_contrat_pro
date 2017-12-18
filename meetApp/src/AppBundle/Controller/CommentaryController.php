<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commentary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Commentary controller.
 *
 * @Route("/admin/commentary")
 * @Security("has_role('ROLE_ADMIN')")
 */
class CommentaryController extends Controller
{
    /**
     * Lists all commentary entities.
     *
     * @Route("/", name="admin_commentary_index")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaries = $em->getRepository('AppBundle:Commentary')->findAll();

        return $this->render('admin/commentary/index.html.twig', array(
            'commentaries' => $commentaries,
        ));
    }

    /**
     * Creates a new commentary entity.
     *
     * @Route("/new", name="commentary_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commentary = new Commentary();
        $form = $this->createForm('AppBundle\Form\CommentaryType', $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentary);
            $em->flush($commentary);

            return $this->redirectToRoute('admin_commentary_index', array('id' => $commentary->getId()));
        }

        return $this->render('admin/commentary/new.html.twig', array(
            'commentary' => $commentary,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentary entity.
     *
     * @Route("/{id}", name="commentary_show", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     */
    public function showAction(Commentary $commentary)
    {
        $deleteForm = $this->createDeleteForm($commentary);

        return $this->render('admin/commentary/show.html.twig', array(
            'commentary' => $commentary,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentary entity.
     *
     * @Route("/{id}/edit", name="commentary_edit", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commentary $commentary)
    {
        $deleteForm = $this->createDeleteForm($commentary);
        $editForm = $this->createForm('AppBundle\Form\CommentaryType', $commentary);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_commentary_index', array('id' => $commentary->getId()));
        }

        return $this->render('admin/commentary/edit.html.twig', array(
            'commentary' => $commentary,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentary entity.
     *
     * @Route("/{id}", name="commentary_delete", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commentary $commentary)
    {
        $form = $this->createDeleteForm($commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentary);
            $em->flush($commentary);
        }

        return $this->redirectToRoute('admin_commentary_index');
    }

    /**
     * Creates a form to delete a commentary entity.
     *
     * @param Commentary $commentary The commentary entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentary $commentary)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentary_delete', array('id' => $commentary->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
