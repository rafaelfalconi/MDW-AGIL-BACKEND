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
     * @Rest\Post("/create")
     */
    public function createAction(Request $request)
    {
        $newreserva = new Reserva();
        $newreserva = $request->get('reserva');

        $em = $this->getDoctrine()->getManager();
        $em->persist($newreserva);
        $flush = $em->flush();
        if ($flush == null) {
            return new View('Reserva insertado correctamente', Response::HTTP_CREATED);
        } else {
            return new View('Reserva no se ha insertado, error con la conexion', Response::HTTP_NO_CONTENT);
        }
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
     * @Rest\Get("/code/{codeR}/hotel/{pinH}")
     */
    public function confirmReservationAction($codeR, $pinH)
    {
        $reservafind = $this->getDoctrine()->getRepository('AppBundle:Reserva')->findOneReservaByCodeHotelPin($codeR, $pinH);
        if (empty($reservafind)) {
            return new View("Reservation not found", Response::HTTP_NOT_FOUND);
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

        $codigo = $request->get('codigo');
        $estado = $request->get('estado');

        $fecha = $request->get('fecha');
        $entrada = $request->get('entrada');
        $salida = $request->get('salida');
        $habitacion = $request->get('habitacion');
        $usuario = $request->get('usuario');
        $customerEmail = $request->get('username');
        $maxDisponible = $request->get('maxdisponible');
        if (empty($fecha) || empty($entrada) || empty($salida) || empty($habitacion) || empty($usuario)) {
            return new View("LOS CAMPOS VACIOS NO ESTAN PERMITIDOS", Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($salida <= $entrada) {
            return new View("HORA DE SALIDA DEBE SER MAYOR A HORA DE ENTRADA", Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($salida > $maxDisponible) {
            return new View("HORA DE SALIDA NO PUEDE SER MAYOR A " . $maxDisponible . ":00H", Response::HTTP_NOT_ACCEPTABLE);
        }
        $habitacion = $this->getDoctrine()->getRepository('AppBundle:Habitacion')->find($habitacion);
        $hotel = $this->getDoctrine()->getRepository('AppBundle:Hotel')->find($habitacion->getHotel());
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($usuario);
        if (empty($codigo)) {
            $codigo = mt_rand(0, 1000000);
        }

        $precio = ($salida - $entrada) * $habitacion->getPrecio();
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

        $email = new SendEmailsController($this->container);
        $email->reservationConfirmation($codigo, $precio, $hotel->getEmail(), $customerEmail);
        $email->reservationPaymentInfo($precio, $codigo, $customerEmail);
        return new View($reserva, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/{id}")
     */
    public function deleteAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $reserva = $this->getDoctrine()->getRepository('AppBundle:Reserva')->find($id);
        if (empty($reserva)) {
            return new View("RESERVA NO ENCONTRADA", Response::HTTP_NOT_FOUND);
        } else {
            $sn->remove($reserva);
            $sn->flush();
        }
        return new View("BORRADO EXITOSAMENTE", Response::HTTP_OK);
    }

}