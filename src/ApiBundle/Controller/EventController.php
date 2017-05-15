<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class EventController extends FOSRestController
{
    CONST EVENTS_NOT_FOUND = "events not found!";

    /**
     * @Rest\Get(
     *     path="/events/"
     * )
     * @ApiDoc(
     *  section="events",
     *  resource=true,
     *  description="Récupération de tous les events.",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the ressource is not found",
     *         401="Returned when auth is required",
     *  },
     * )
     */
    public function getEventsAction(){
        $em = $this->getDoctrine()->getManager();

        $view = View::create();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        if(!$events)
            $view->setStatusCode(Response::HTTP_NOT_FOUND)->setData(self::EVENTS_NOT_FOUND);
        else
            $view->setStatusCode(Response::HTTP_OK)->setData($events);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * @Rest\Get(
     *     path="/event/{id}"
     * )
     * @ApiDoc(
     *  section="events",
     *  resource=true,
     *  description="Récupération d'un event.",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the ressource is not found",
     *         401="Returned when auth is required",
     *  },
     * )
     * @ParamConverter("event", options={"mapping": {"id": "id"}})
     */
    public function getEventAction(Event $event){

        $view = View::create();

        if(!$event)
            $view->setStatusCode(Response::HTTP_NOT_FOUND)->setData(self::EVENTS_NOT_FOUND);
        else
            $view->setStatusCode(Response::HTTP_OK)->setData($event);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
