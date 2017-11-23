<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 20/09/17
 * Time: 16:39
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{

    /**
     * @Route("/admin", name="dashboard")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
//        $nbAdress   = $em->getRepository('AppBundle:Adress')->findAll();
//        $nbCategory   = $em->getRepository('AppBundle:Category')->findAll();
//        $nbCommentary   = $em->getRepository('AppBundle:Commentary')->findAll();
//        $nbMessage   = $em->getRepository('AppBundle:Message')->findAll();
//        $nbEvent   = $em->getRepository('AppBundle:Event')->findAll();
        $nbUsers = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/dashboard/index.html.twig', [
            'nbUsers' => $nbUsers
        ]);
    }
}