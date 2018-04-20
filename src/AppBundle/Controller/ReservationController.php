<?php
/**
 * Created by PhpStorm.
 * User: Moons
 * Date: 19/4/2018
 * Time: 17:52
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Reserva;



class ReservationController extends Controller
{
    /**
     * @Rest\Get("/reservation")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Reserva')->findAll();
        if ($restresult === null) {
            return new View("there are no reservation exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/reservation/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Reserva')->find($id);
        if ($singleresult === null) {
            return new View("Reservation not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

}