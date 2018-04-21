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
    /**
     * @Rest\Post("/reservation")
     */
    public function postAction(Request $request)
    {

        $reserva = new Reserva;
        $fecha = $request->get('fecha');
        $entrada = $request->get('entrada');
        $salida = $request->get('salida');
        $habitacion = $request->get('habitacion');
        $usuario = $request->get('usuario');
        if(empty($fecha) || empty($entrada) || empty($salida) || empty($habitacion) || empty($usuario))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $habitacion = $this->getDoctrine()->getRepository('AppBundle:Habitacion')->find($habitacion);
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($usuario);

        $reserva->setFecha(new \DateTime($fecha));
        $reserva->setEstado(false);
        $reserva->setEntrada($entrada);
        $reserva->setSalida($salida);
        $reserva->setCodigo(mt_rand(0, 1000000));
        $reserva->setHabitacion($habitacion);
        $reserva->setUsuario($usuario);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserva);
        $em->flush();
        return new View("Reserva Added Successfully", Response::HTTP_OK);

    } 
}