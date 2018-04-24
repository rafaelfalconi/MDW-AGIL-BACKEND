<?php
/**
 * Created by PhpStorm.
 * User: Moons
 * Date: 19/4/2018
 * Time: 17:52
 */

namespace AppBundle\Controller;

use phpDocumentor\Reflection\Types\This;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Reserva;
use AppBundle\Controller\SendCustomerEmailController;

/**
 * @Rest\Route("api/v1/reservas")
 */
class ReservaController extends FOSRestController
{
    /**
     * @Rest\Get("")
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
     * @Rest\Get("/hotel/{id}")
     */
    public function getReservasByHotelAction($id)
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Reserva')->findAllReservasByHotel($id);
        if ($restresult === null) {
            return new View("there are no reservation exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/{id}")
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
     * @Rest\Get("/code/{codeReservation}")
     */
    public function confirmReservationAction($codeReservation)
    {
        $em = $this->getDoctrine()->getManager();
        $reservafind = $this->getDoctrine()->getRepository('AppBundle:Reserva')->findBy(['codigo' => $codeReservation]);
        if (empty($reservafind)) {
            return new View("Categoría no encontrada", Response::HTTP_NOT_FOUND);
        }
        return $reservafind;
    }

    /**
     * @Rest\Put("/{id}/update")
     * @param $id
     */
    public function updateReserva($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $reserva = $this->getDoctrine()->getRepository(Reserva::class)->find($id);
        $reserva->setEstado(true);

        $em->persist($reserva);
        $flush = $em->flush();
        if ($flush == null) {
            echo "Reserva actualizado correctamente";
        } else {
            echo "Reserva no se ha actualizado";
        }
    }

    /**
     * @Rest\Post("")
     */
    public function postAction(Request $request)
    {

        $reserva = new Reserva;
        $sendEmail = new SendCustomerEmailController;

        $fecha = $request->get('fecha');
        $entrada = $request->get('entrada');
        $salida = $request->get('salida');
        $habitacion = $request->get('habitacion');
        $usuario = $request->get('usuario');
        $customerEmail = $request->get('username');
        if (empty($fecha) || empty($entrada) || empty($salida) || empty($habitacion) || empty($usuario)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }

        $habitacion = $this->getDoctrine()->getRepository('AppBundle:Habitacion')->find($habitacion);
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($usuario);
        $codigo=mt_rand(0, 1000000);
        $precio=($salida-$entrada)*$habitacion->getPrecio();
        $reserva->setFecha(new \DateTime($fecha));
        $reserva->setEstado(false);
        $reserva->setEntrada($entrada);
        $reserva->setSalida($salida);
        $reserva->setCodigo($codigo);
        $reserva->setHabitacion($habitacion);
        $reserva->setUsuario($usuario);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reserva);
        $em->flush();

        //$sendEmail->sendCustomerEmail($codigo, $precio, 'a@a.a', "manager@a.a", $customerEmail);
        return new View("Reserva Added Successfully", Response::HTTP_OK);

    }

}