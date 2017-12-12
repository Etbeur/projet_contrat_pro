<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 19/10/17
 * Time: 15:42
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomePageController extends Controller
{
//    public $id;

    /**
     * @Route("/", name="homePage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AppBundle:Event')->eventDateAscendingOrder();

        return $this->render('homePage.html.twig', [
            'events' => $events,
        ]);
    }
}
