<?php
//
//namespace AppBundle\Controller;
//
//use AppBundle\Entity\Message;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
//
///**
// * Message controller.
// *
// * @Route("/admin/message")
// * @Security("has_role('ROLE_ADMIN')")
// */
//class MessageController extends Controller
//{
//    /**
//     * Lists all message entities.
//     *
//     * @Route("/", name="admin_message_index")
//     * @Security("has_role('ROLE_ADMIN')")
//     * @Method("GET")
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $messages = $em->getRepository('AppBundle:Message')->findAll();
//
//        return $this->render('admin/message/index.html.twig', array(
//            'messages' => $messages,
//        ));
//    }
//
//    /**
//     * Creates a new message entity.
//     *
//     * @Route("/new", name="message_new")
//     * @Security("has_role('ROLE_ADMIN')")
//     * @Method({"GET", "POST"})
//     */
//    public function newAction(Request $request)
//    {
//        $message = new Message();
//        $form = $this->createForm('AppBundle\Form\MessageType', $message);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($message);
//            $em->flush($message);
//
//            return $this->redirectToRoute('message_show', array('id' => $message->getId()));
//        }
//
//        return $this->render('admin/message/new.html.twig', array(
//            'message' => $message,
//            'form' => $form->createView(),
//        ));
//    }
//
//    /**
//     * Finds and displays a message entity.
//     *
//     * @Route("/{id}", name="message_show", requirements={"id": "\d+"})
//     * @Security("has_role('ROLE_ADMIN')")
//     * @Method("GET")
//     */
//    public function showAction(Message $message)
//    {
//        $deleteForm = $this->createDeleteForm($message);
//
//        return $this->render('admin/message/show_delete_event.html.twig', array(
//            'message' => $message,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Displays a form to edit an existing message entity.
//     *
//     * @Route("/{id}/edit", name="message_edit", requirements={"id": "\d+"})
//     * @Security("has_role('ROLE_ADMIN')")
//     * @Method({"GET", "POST"})
//     */
//    public function editAction(Request $request, Message $message)
//    {
//        $deleteForm = $this->createDeleteForm($message);
//        $editForm = $this->createForm('AppBundle\Form\MessageType', $message);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('message_edit', array('id' => $message->getId()));
//        }
//
//        return $this->render('admin/message/edit.html.twig', array(
//            'message' => $message,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Deletes a message entity.
//     *
//     * @Route("/{id}", name="message_delete", requirements={"id": "\d+"})
//     * @Security("has_role('ROLE_ADMIN')")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, Message $message)
//    {
//        $form = $this->createDeleteForm($message);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($message);
//            $em->flush($message);
//        }
//
//        return $this->redirectToRoute('message_index');
//    }
//
//    /**
//     * Creates a form to delete a message entity.
//     *
//     * @param Message $message The message entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Message $message)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('message_delete', array('id' => $message->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
//}
