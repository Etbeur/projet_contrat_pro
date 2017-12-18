<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 13/12/17
 * Time: 21:06
 */
namespace UserBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("/user")
 * @Security("has_role('ROLE_USER')")
 */
class AccountUserController extends Controller
{
    /**
     * Finds and displays a event.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}", name="user_account_show_delete", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showDeleteUserAccountAction(User $user)
    {
        $deleteForm = $this->createDeleteFormUser($user);

        return $this->render('user/account/show_delete_account.html.twig', array(
            '$user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing account.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/profile", name="user_account_edit", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function editAccountAction(Request $request, User $user)
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
     * Deletes a User.
     * @Security("has_role('ROLE_USER')")
     * @Route("/{id}/delaccount", name="user_account_delete", requirements={"id" :"\d+"})
     * @Method("DELETE")
     */
    public function deleteUserAction(Request $request, User $user)
    {
        $form = $this->createDeleteFormUser($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush($user);
        }

        return $this->redirectToRoute('homePage');
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
            ->setAction($this->generateUrl('user_account_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
