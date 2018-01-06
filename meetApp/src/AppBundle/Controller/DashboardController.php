<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{

    /**
     * @Route("/admin", name="dashboard")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nbEvents   = $em->getRepository('AppBundle:Event')->findAll();
        $nbUsers = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/dashboard/index.html.twig', [
            'nbUsers' => $nbUsers,
            'nbEvents' => $nbEvents
        ]);
    }
}