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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * Creates a new event.
     *
     * @Route("/new", name="user_event_new")
     * @Security("has_role('ROLE_USER')")
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
     * Finds and displays a event.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}", name="user_event_show_delete", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteFormEvent($event);

        return $this->render('user/event/show_delete_event.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/edit", name="user_event_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteFormEvent($event);
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
     * Displays a form to edit an existing account.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/profile", name="user_account_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function modifyAccontAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteFormUser($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/account/edit_account.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Add choosen event in user event.
     *
     * @Route("/{id}/add", name="user_event_add", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @param Event $event
     *
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addUserEvent(Request $request, Event $event)
    {

        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->setData($event->addParticipant(
            $this->container
            ->get('security.token_storage')
            ->getToken()
            ->getUser()
        ));

        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid() &&
            count($event->getParticipants()) <= $event->gettotalCapacity()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('homePage');
        }

        return $this->render('user/event/show_add_event.html.twig', array(
            'events' => $event,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Remove event in user choosen event.
     *
     * @Route("/{id}/del", name="user_event_remove", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_USER')")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @param Event $event
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function removeUserEvent(Request $request, Event $event)
    {
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->setData($event->removeParticipant(
            $this->container
                ->get('security.token_storage')
                ->getToken()
                ->getUser()
        ));

        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid() &&
            count($event->getParticipants()) < $event->gettotalCapacity()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('homePage');
        }



        return $this->render('user/event/show_delete_user_event.html.twig', array(
            'events' => $event,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}", name="user_event_delete", requirements={"id" :"\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteFormEvent($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush($event);
        }

        return $this->redirectToRoute('homePage');
    }

    /**
     * Creates a form to delete a event.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFormEvent(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Creates a form to delete a user.
     *
     * @param User $user
     *
     * @return \Symfony\Component\Form\Form The form
     * @internal param User $user The user entity
     *
     */
    private function createDeleteFormUser(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
