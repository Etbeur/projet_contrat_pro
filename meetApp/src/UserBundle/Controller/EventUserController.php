<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 17/11/17
 * Time: 14:55
 */

namespace UserBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/event")
 */
class EventUserController extends Controller
{
    /**
     * List all Event
     *
     * @Route("/", name="user_event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

            $events = $em->getRepository('AppBundle:Event')->eventDateAscendingOrder();

        return $this->render('user/event/index_event.html.twig', array(
            "events" => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="user_event_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $event->setCreator($this->container->get('security.token_storage')->getToken()->getUser());
        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush($event);

            return $this->redirectToRoute('user_event_index', array( 'id' => $event->getId() ));
        }

        return $this->render('user/event/new.html.twig', array(
            'events' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="user_event_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('user/event/show_delete_event.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="user_event_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homePage', array('id' => $event->getId()));
        }

        return $this->render('user/event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Add choosen event in user event.
     *
     * @Route("/{id}/add", name="user_event_add", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addUserEvent(Request $request)
    {
        $event = new Event();
        $event->setBooking(true);

        if ($event->getBooking() == true) {
            $event->setParticipants(count(+1));
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush($event);

            return $this->redirectToRoute('homePage', array( 'id' => $event->getId() ));
        }

        return $this->render('user/event/index_event.html.twig', array(
            'events' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="user_event_delete", requirements={"id" :"\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush($event);
        }

        return $this->redirectToRoute('homePage');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
