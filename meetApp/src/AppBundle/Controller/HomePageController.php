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

class HomePageController extends Controller {

    /**
     * @Route("/", name="homePage")
     */
    public function indexAction()
    {
        return $this->render('homePage.html.twig', [
        ]);
    }
}