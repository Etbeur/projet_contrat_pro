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
//        if ($this->container->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")) {
//            $users = $this->container->get('security.token_storage')->getToken()->getUser();
//            $this->id = $users->getId();
//        }
        $events = $em->getRepository('AppBundle:Event')->findAll();
        $books = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('homePage.html.twig', [
            'events' => $events,
            'books' => $books
//            'users' => $this->id
        ]);
    }
}
