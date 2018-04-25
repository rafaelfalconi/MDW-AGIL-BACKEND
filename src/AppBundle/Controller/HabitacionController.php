<?php
/**
 * Created by PhpStorm.
 * User: rafaelfalconi
 * Date: 19/4/18
 * Time: 16:31
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Reserva;

/**
 * @Rest\Route("api/v1/habitaciones")
 */
class HabitacionController extends FOSRestController
{
    /**
     * @Rest\GET()
     */
    public function getAction(Request $request)
    {
        $habitaciones = $this->getDoctrine()->getRepository('AppBundle:Habitacion')->findAll();
        if ($habitaciones === null) {

        }
        if(empty($request->get('fecha')) && empty($request->get('hora'))){
            return new View("No hay habitaciones registrados", Response::HTTP_NOT_FOUND);
        }else{
            $fecha = $request->get('fecha');
            $porciones = explode("/", $fecha);
            $entrada = $porciones[2] . "-" . $porciones[0] . "-" . $porciones[1];
            $hora = $request->get('hora') - 2;
            $arrayresult = array();
            foreach ($habitaciones as $habitacion) {
                $repository = $this->getDoctrine()
                    ->getRepository(Reserva::class);
                $query = $repository->createQueryBuilder('r')
                    ->where('r.salida >= :entrada and r.fecha= :fecha and r.habitacion= :habitacion')
                    ->setParameters(array("entrada" => $hora, "fecha" => $entrada, "habitacion" => $habitacion))
                    ->orderBy('r.entrada', 'ASC')
                    ->setMaxResults(1)
                    ->getQuery();
                $result = $query->getResult();
                $resultA = new Reserva();
                if (empty($result)) {
                    $resultA->setEntrada(24);
                    $resultA->setSalida(24);
                    $resultA->setCodigo(0);
                    $resultA->setHabitacion($habitacion);

                } else {
                    $resultA = $result[0];
                }
                $query = $repository->createQueryBuilder('r')
                    ->where('r.salida > :entrada and r.fecha= :fecha and r.habitacion= :habitacion')
                    ->setParameters(array("entrada" => $resultA->getSalida(), "fecha" => $entrada, "habitacion" => $habitacion))
                    ->orderBy('r.entrada', 'ASC')
                    ->setMaxResults(1)
                    ->getQuery();
                $result = $query->getResult();
                $resultB = new Reserva();
                if (empty($result)) {
                    $resultB->setEntrada(24);
                    $resultB->setSalida(24);
                    $resultB->setCodigo(0);
                    $resultB->setHabitacion($habitacion);

                } else {
                    $resultB = $result[0];
                }
                $return = new Reserva();
                if ($resultB->getEntrada() == 24 && $resultA->getEntrada() == 24) {
                    $return->setEntrada($request->get('hora'));
                    $return->setSalida(24);
                    $return->setCodigo(0);
                    $return->setHabitacion($habitacion);
                    array_push($arrayresult, $return);
                } elseif (($resultA->getSalida() > $resultB->getEntrada()) || ($request->get('hora') == $resultB->getEntrada()) || ($request->get('hora') < ($resultA->getSalida() + 2))) {

                }  else {
                    $return->setEntrada($request->get('hora'));
                    $return->setSalida($resultB->getEntrada());
                    $return->setCodigo(0);
                    $return->setHabitacion($habitacion);
                    array_push($arrayresult, $return);
                }

            }

            if (count($arrayresult) == 0) {
                return new View("No hay habitaciones para esa fecha", Response::HTTP_NOT_FOUND);
            }
            return $arrayresult;
        }

    }
}