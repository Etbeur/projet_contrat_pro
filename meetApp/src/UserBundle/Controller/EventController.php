<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 17/11/17
 * Time: 14:55
 */

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * List all Event
     *
     * @Route("/", name="event_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('user/event/index_event.html.twig', array(
            "events" => $events,
        ));
    }
}
