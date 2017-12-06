<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 04/12/17
 * Time: 16:31
 */

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserEvent
{
    /**
     * Add choosen event in user event.
     *
     * @Route("/eventcrud/{id}", name="event_crud")
     * @Method({"PUT", "DELETE"})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function crudAjaxAction(Request $request)
    {
        $eventSce = $this->get('user.helper.event');

        switch ($request->getMethod()) {
            case 'PUT';
                $params = $eventSce->add($request->request->get('eventid'));

            case 'DELETE';
                $params = $eventSce->delete($request->query->get('eventid'));
        }

        $response = new JsonResponse();
        $response->setData($params);

        return $response;

    }

}